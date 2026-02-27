import { useEffect, useState } from 'react';
import axios from 'axios';
import ProductForm from './components/ProductForm';
import Login from './components/Login';
import Barcode from 'react-barcode';
import './App.css';

function App() {
  const [productos, setProductos] = useState([]);
  const [carrito, setCarrito] = useState([]);
  const [busqueda, setBusqueda] = useState('');
  const [historial, setHistorial] = useState([]);
  const [vista, setVista] = useState('venta'); // 'venta' o 'historial'
  const [token, setToken] = useState(localStorage.getItem('auth_token'));

  // Configuración global de Axios para usar el Token
  if (token) axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

  // --- CERRAR SESIÓN ---
  const handleLogout = () => {
    setToken(null);
    localStorage.removeItem('auth_token');
    setCarrito([]);
  };

  // --- CARGAR DATOS ---
  const cargarProductos = () => {
    axios.get('http://127.0.0.1:8000/api/products')
      .then(res => setProductos(res.data))
      .catch(err => { if (err.response && err.response.status === 401) handleLogout(); });
  };

  const cargarHistorial = () => {
    axios.get('http://127.0.0.1:8000/api/inventory/all')
      .then(res => setHistorial(res.data))
      .catch(err => console.error("Error cargando historial", err));
  };

  useEffect(() => { 
    if (token) {
        cargarProductos();
        cargarHistorial(); 
    } 
  }, [token]);

  // --- LÓGICA DE SURTIDO (INVENTARIO) ---
  const surtirProducto = async (producto) => {
    const cantidadStr = prompt(`📦 Llegó proveedor de: ${producto.name}\n¿Cuántas unidades llegaron?`);
    if (!cantidadStr) return;
    
    const cantidad = parseInt(cantidadStr);
    if (isNaN(cantidad) || cantidad <= 0) return alert("Cantidad inválida");

    try {
      await axios.post('http://127.0.0.1:8000/api/inventory/add', {
        product_id: producto.id,
        quantity: cantidad,
        reason: "Compra rápida desde POS"
      });
      alert("✅ Inventario actualizado");
      cargarProductos();
      cargarHistorial();
    } catch (error) { 
        alert("Error al surtir. Verifica tu conexión."); 
    }
  };

  // --- LÓGICA DE CORTE DE CAJA (Z-REPORT) ---
  const hacerCorteCaja = async () => {
    try {
      const res = await axios.get('http://127.0.0.1:8000/api/sales/daily-summary');
      const { total_money, total_sales, top_product } = res.data;
      
      alert(
        `📅 REPORTE DEL DÍA (CORTE DE CAJA)\n` +
        `----------------------------------\n` +
        `💰 Dinero en Caja:   $${parseFloat(total_money).toFixed(2)}\n` +
        `🧾 Transacciones:    ${total_sales}\n` +
        `🏆 Producto Top:     ${top_product}\n` +
        `----------------------------------\n` +
        `Cierre realizado a las: ${new Date().toLocaleTimeString()}`
      );
    } catch (error) {
      alert("Error al obtener el corte del día.");
    }
  };

  // --- LÓGICA DE VENTA (CARRITO) ---
  const agregarAlCarrito = (producto) => {
    const existe = carrito.find(item => item.id === producto.id);
    if (existe) {
      setCarrito(carrito.map(item => item.id === producto.id ? { ...item, cantidad: item.cantidad + 1 } : item));
    } else {
      setCarrito([...carrito, { ...producto, cantidad: 1 }]);
    }
  };

  const eliminarDelCarrito = (id) => { setCarrito(carrito.filter(item => item.id !== id)); };

  const totalVenta = carrito.reduce((sum, item) => sum + (item.price * item.cantidad), 0);

  const cobrar = async () => {
    if (carrito.length === 0) return;
    try {
      await axios.post('http://127.0.0.1:8000/api/sales', { cart: carrito.map(item => ({ id: item.id, quantity: item.cantidad })) });
      alert('¡Venta Exitosa! 💰 Ticket guardado.');
      setCarrito([]);
      cargarProductos();
      cargarHistorial();
    } catch (error) { alert("Error al procesar la venta."); }
  };

  // Si no hay token, mostramos Login
  if (!token) return <Login onLogin={(t) => setToken(t)} />;

  return (
    <div className="app-container">
      
      {/* 🟢 COLUMNA IZQUIERDA: ÁREA DE TRABAJO */}
      <div className="catalog-section">
        
        {/* HEADER / BOTONERA SUPERIOR */}
        <header className="header">
          {/* ... dentro de <header className="header"> ... */}

<div className="brand-title" style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
    {/* LOGO PEQUEÑO */}
    <img 
        src="https://upload.wikimedia.org/wikipedia/commons/6/66/Oxxo_Logo.svg" 
        alt="Logo OXXO" 
        style={{ height: '50px' }} // Altura ajustada para el header
    />
    
    {/* Título al lado */}
    <span style={{ fontSize: '1.5rem', color: '#d32f2f' }}>INVENTARIO OXXO</span>
</div>

{/* ... resto de los botones del header ... */}
          
          <div style={{ display: 'flex', gap: '10px' }}>
             <button 
                onClick={() => setVista('venta')} 
                className="logout-btn" 
                style={{ background: vista === 'venta' ? '#d32f2f' : '#888' }}
             >
                🛒 Ventas
             </button>
             <button 
                onClick={() => { setVista('historial'); cargarHistorial(); }} 
                className="logout-btn"
                style={{ background: vista === 'historial' ? '#d32f2f' : '#888' }}
             >
                📜 Historial
             </button>
             
             {/* BOTÓN DE CORTE Z */}
             <button 
                onClick={hacerCorteCaja} 
                className="logout-btn"
                style={{ background: '#2e7d32', marginRight: '5px' }}
             >
                💰 Corte Z
             </button>

             <button onClick={handleLogout} className="logout-btn" style={{ background: '#333' }}>Salir</button>
          </div>
        </header>

        {/* --- VISTA: CAJA REGISTRADORA (VENTAS) --- */}
        {vista === 'venta' && (
            <>
                {/* BUSCADOR */}
                <input 
                    type="text" 
                    placeholder="🔍 Buscar producto (ej: Coca, Sabritas...)" 
                    className="search-input"
                    value={busqueda}
                    onChange={(e) => setBusqueda(e.target.value)}
                />

                {/* FORMULARIO DE REGISTRO */}
                <ProductForm onProductAdded={cargarProductos} />

                {/* GRID DE PRODUCTOS */}
                <div className="products-grid">
                {productos
                    .filter(p => p.name.toLowerCase().includes(busqueda.toLowerCase())) 
                    .map(prod => (
                    <div key={prod.id} className="product-card" onClick={() => agregarAlCarrito(prod)}>
                    
                        <div className="card-title">{prod.name}</div>
                        
                        <div style={{ display: 'flex', justifyContent: 'center', opacity: 0.8 }}>
                            <Barcode value={prod.sku} width={1} height={25} fontSize={10} displayValue={false} />
                        </div>
                        
                        <div className="card-price">${prod.price}</div>
                        
                        <div className={`stock-badge ${prod.stock <= prod.min_stock ? 'low' : ''}`}>
                            Stock: {prod.stock} {prod.stock <= prod.min_stock && '⚠️'}
                        </div>
                        
                        <button 
                            className="restock-btn"
                            onClick={(e) => { 
                                e.stopPropagation(); // Evita que se agregue al carrito al surtir
                                surtirProducto(prod); 
                            }}
                        >
                            📦 + Surtir
                        </button>

                    </div>
                ))}
                </div>
            </>
        )}

        {/* --- VISTA: HISTORIAL DE MOVIMIENTOS --- */}
        {vista === 'historial' && (
            <div className="history-container">
                <h2 style={{ color: '#333', marginBottom: '15px' }}>📜 Historial de Movimientos (Últimos 50)</h2>
                <table className="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Razón / Detalle</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        {historial.map(mov => (
                            <tr key={mov.id}>
                                <td>{new Date(mov.created_at).toLocaleString()}</td>
                                <td>
                                    <span className={`badge ${mov.type}`}>
                                        {mov.type === 'entrada' ? '📥 COMPRA' : '📤 VENTA'}
                                    </span>
                                </td>
                                <td>{mov.product ? mov.product.name : 'Eliminado'}</td>
                                <td style={{ fontWeight: 'bold' }}>{mov.quantity}</td>
                                <td style={{ color: '#666', fontStyle: 'italic' }}>{mov.reason}</td>
                                <td>{mov.user ? mov.user.name : 'Desconocido'}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        )}

      </div>

      {/* 🔴 COLUMNA DERECHA: TICKET (Siempre visible) */}
      <div className="ticket-section">
        <div className="ticket-header">
          <h2>TICKET DE VENTA</h2>
          <p style={{ fontSize: '0.8rem', opacity: 0.8 }}>Folio: #{Date.now().toString().slice(-6)}</p>
        </div>
        
        <div className="ticket-items">
          {carrito.length === 0 ? (
            <div style={{ textAlign: 'center', color: '#999', marginTop: '50px' }}>
              <p>🛒 Carrito vacío</p>
            </div>
          ) : (
            carrito.map(item => (
              <div key={item.id} className="ticket-item">
                <div>
                  <div className="item-name">{item.name}</div>
                  <div className="item-qty">{item.cantidad} x ${item.price}</div>
                </div>
                <div style={{ display: 'flex', alignItems: 'center' }}>
                  <span style={{ fontWeight: 'bold' }}>${(item.cantidad * item.price).toFixed(2)}</span>
                  <button onClick={() => eliminarDelCarrito(item.id)} className="remove-btn">×</button>
                </div>
              </div>
            ))
          )}
        </div>

        <div className="ticket-footer">
          <div className="total-row">
            <span>TOTAL</span>
            <span>${totalVenta.toFixed(2)}</span>
          </div>
          <button onClick={cobrar} disabled={carrito.length === 0} className="pay-btn">
            COBRAR (F12)
          </button>
        </div>
      </div>

    </div>
  );
}

export default App;