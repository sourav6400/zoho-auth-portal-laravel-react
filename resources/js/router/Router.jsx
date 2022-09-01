// import "bootstrap/dist/css/bootstrap.min.css";
// import "bootstrap/dist/js/bootstrap.js";

import React from 'react';
import { Routes, Route, Link } from 'react-router-dom';

import Home from '../components/Home';
import Login from '../components/Login';
import Register from '../components/Register';
import Dashboard from '../components/Dashboard';
import NotFound from '../components/NotFound';


const Router = () => {
    return (
        <div>
            <div>
                <nav className="navbar navbar-inverse">
                    <div className="container-fluid">
                        <div className="navbar-header">
                        
                        </div>
                        <ul className="nav navbar-nav">
                            <li><Link to="/login">Login</Link></li>
                            <li><Link to="/register">Register</Link></li>
                            <li><Link to="/dashboard">Dashboard</Link></li>
                            <li className="active"><Link to="/">Home</Link></li>
                        </ul>
                    </div>
                </nav>

                <div className="container">
                    <h3>Zoho Portal With Laravel-9 & React JS</h3>
                    <Routes>
                        <Route path="/login" element={<Login />} />
                        <Route path="/register" element={<Register />} />
                        <Route path="/dashboard" element={<Dashboard />} />
                        
                        <Route path="/" element={<Home />} />
                        <Route path="/*" element={<NotFound />} />
                    </Routes>
                </div>

            </div>
        </div>
    )
}

export default Router