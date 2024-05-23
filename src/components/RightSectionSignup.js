// src/components/RightSectionSignup.js
import React from "react";
import SafeRentVideo from "../assets/SafeRent_Video.mp4";
import "./RightSection.css";

const RightSection = () => {
  return (
    <div className="right-section">
      <video className="background-video" autoPlay loop muted>
        <source src={SafeRentVideo} type="video/mp4" />
        Your browser does not support the video tag.
      </video>
      <h1 className="logo">SafeRent</h1>
    </div>
  );
};

export default RightSection;
