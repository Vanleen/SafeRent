import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./VerifyOtpPage.css";

const VerifyOtpPage = () => {
  const [otp, setOtp] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate();

  const handleVerifyOtp = async (e) => {
    e.preventDefault();
    const response = await fetch("http://localhost:5000/verify-otp", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ otp }),
    });
    const data = await response.json();
    setMessage(data.message);
    if (data.success) {
      navigate("/reset-password");
    }
  };

  return (
    <div className="verify-otp-page">
      <h1>Verify OTP</h1>
      <form onSubmit={handleVerifyOtp}>
        <label>OTP:</label>
        <input
          type="text"
          value={otp}
          onChange={(e) => setOtp(e.target.value)}
          required
        />
        <button type="submit">Verify</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
};

export default VerifyOtpPage;
