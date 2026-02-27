import { useState } from 'react';
import axios from 'axios';

const Login = ({ onLogin }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(''); // Limpiar errores previos

        try {
            // Hacemos la petición a Laravel
            const response = await axios.post('http://127.0.0.1:8000/api/login', {
                email,
                password
            });
            
            // Si sale bien, guardamos el token
            localStorage.setItem('auth_token', response.data.access_token);
            onLogin(response.data.access_token);

        } catch (err) {
            console.error(err);
            setError('❌ Credenciales incorrectas. Intenta de nuevo.');
        }
    };

    return (
        <div className="login-container">
            
    <form onSubmit={handleSubmit} className="login-card">
    
    {/* 👇 AQUÍ PONEMOS EL LOGO DE OXXO 👇 */}
    <img 
        src="https://upload.wikimedia.org/wikipedia/commons/6/66/Oxxo_Logo.svg" 
        alt="Logo OXXO" 
        style={{ width: '180px', marginBottom: '20px' }} 
    />
    
    {/* Puedes dejar este texto más pequeño o borrarlo */}
    <h2 style={{ color: '#333', marginBottom: '20px', fontSize: '1.2rem' }}>
        Control de Inventario
    </h2>

    {/* ... resto de tu formulario (inputs de error, email, password)... */}
                <p style={{ color: '#666', marginBottom: '30px' }}>Ingresa tus credenciales</p>

                {/* Mensaje de Error */}
                {error && (
                    <div style={{ 
                        background: '#ffebee', 
                        color: '#c62828', 
                        padding: '10px', 
                        borderRadius: '6px', 
                        marginBottom: '15px',
                        fontSize: '0.9rem'
                    }}>
                        {error}
                    </div>
                )}

                <input 
                    type="email" 
                    placeholder="Correo electrónico" 
                    className="login-input"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />

                <input 
                    type="password" 
                    placeholder="Contraseña" 
                    className="login-input"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />

                <button type="submit" className="login-btn">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    );
};

export default Login;