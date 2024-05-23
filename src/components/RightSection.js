// src/components/RightSection.js
import React from 'react';
import './RightSection.css';
import Video from '../assets/SafeRent_Video.mp4'; // Importer la vidéo
import Logo from '../assets/Safe.svg'; // Importer le logo blanc

const RightSection = () => {
  return (
    <div className="right-section">
      <video autoPlay loop muted className="background-video">
        <source src={Video} type="video/mp4" />
        Your browser does not support the video tag.
      </video>
      <img src={Logo} alt="SafeRent Logo" className="logo" />
    </div>
  );
};

export default RightSection;
