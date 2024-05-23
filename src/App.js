// src/App.js
import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import ConnexionPage from "./pages/ConnexionPage";
import ForgotPasswordPage from "./pages/ForgotPasswordPage";
import VerifyOtpPage from "./pages/VerifyOtpPage";
import ResetPasswordPage from "./pages/ResetPasswordPage";
import SignupPage from "./pages/SignupPage";
import Home from "./pages/Home"; // Importer la page Home
import ProtectedRoute from "./components/ProtectedRoute"; // Importer ProtectedRoute

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />{" "}
        {/* Définir Home comme route par défaut */}
        <Route path="/signin" element={<ConnexionPage />} />
        <Route path="/forgot-password" element={<ForgotPasswordPage />} />
        <Route path="/verify-otp" element={<VerifyOtpPage />} />
        <Route path="/reset-password" element={<ResetPasswordPage />} />
        <Route path="/signup" element={<SignupPage />} />
        <Route element={<ProtectedRoute />}>
          <Route path="/home" element={<Home />} />{" "}
          {/* Définir Home comme route protégée */}
        </Route>
      </Routes>
    </Router>
  );
}

export default App;
