import { useState } from 'react';
import axios from 'axios';

function ProductForm({ onProductAdded }) {
  const [formData, setFormData] = useState({
    sku: '',
    name: '',
    description: '',
    price: '',
    stock: '',
    min_stock: 5
  });

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('http://127.0.0.1:8000/api/products', formData);
      alert('¡Producto guardado! 🛒');

      setFormData({
        sku: '',
        name: '',
        description: '',
        price: '',
        stock: '',
        min_stock: 5
      });

      if (onProductAdded) onProductAdded();

    } catch (error) {
      console.error(error);
      alert('Error al guardar. Revisa que el SKU no esté repetido.');
    }
  };

  return (
    <div className="form-container">
      <h2 style={{ color: '#d32f2f' }}>Nuevo Producto</h2>

      <form onSubmit={handleSubmit}>

        <input
          className="form-input"
          name="sku"
          type="text"
          maxLength="13"
          placeholder="Escanea o escribe el SKU (EAN-13)"
          value={formData.sku}
          onChange={(e) => {
            const re = /^[0-9\b]+$/;
            if (e.target.value === '' || re.test(e.target.value)) {
              handleChange(e);
            }
          }}
          required
        />

        <input
          className="form-input"
          name="name"
          placeholder="Nombre del Producto"
          value={formData.name}
          onChange={handleChange}
          required
        />

        <input
          className="form-input"
          name="description"
          placeholder="Descripción"
          value={formData.description}
          onChange={handleChange}
        />

        <div style={{ display: 'flex', gap: '10px' }}>
          <input
            className="form-input"
            name="price"
            type="number"
            placeholder="Precio $"
            step="0.50"
            value={formData.price}
            onChange={handleChange}
            required
            style={{ marginBottom: 0 }}
          />

          <input
            className="form-input"
            name="stock"
            type="number"
            placeholder="Stock Inicial"
            value={formData.stock}
            onChange={handleChange}
            required
            style={{ marginBottom: 0 }}
          />
        </div>

        <button type="submit" className="save-btn">
          GUARDAR EN INVENTARIO
        </button>

      </form>
    </div>
  );
}

export default ProductForm;