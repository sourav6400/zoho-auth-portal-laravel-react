// import './bootstrap'

// import "bootstrap/dist/css/bootstrap.min.css";
// import "bootstrap/dist/js/bootstrap.js";

import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'

import AppComponent from './components/App'

ReactDOM.createRoot(document.getElementById('app')).render(
    <BrowserRouter>
        <AppComponent />
    </BrowserRouter>
)