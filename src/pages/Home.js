// src/pages/Home.js
import React, { useState } from "react";
import { Link } from "react-router-dom";
import { FiMenu, FiX } from "react-icons/fi";
import { FaFacebookF, FaLinkedinIn, FaInstagram, FaTiktok, FaYoutube } from "react-icons/fa";
import "./Home.css";
import Logo from "../assets/Safe.svg";
import Video from "../assets/SafeRent_Video.mp4";

const Home = () => {
  const [burgerOpen, setBurgerOpen] = useState(false);

  const toggleBurgerMenu = () => {
    setBurgerOpen(!burgerOpen);
  };

  return (
    <div className={`home-container ${burgerOpen ? "no-scroll" : ""}`}>
      <nav className="home-nav">
        <div className="nav-content">
          <img src={Logo} alt="SafeRent Logo" className="home-logo" />
          <ul className="home-menu">
            <li><Link to="/signin">Sign In</Link></li>
            <li><Link to="/signup">Discover SafeRent</Link></li>
            <li><Link to="/about">About SafeRent</Link></li>
          </ul>
          <div className="social-icons">
            <a href="https://facebook.com"><FaFacebookF /></a>
            <a href="https://linkedin.com"><FaLinkedinIn /></a>
            <a href="https://instagram.com"><FaInstagram /></a>
            <a href="https://tiktok.com"><FaTiktok /></a>
            <a href="https://youtube.com"><FaYoutube /></a>
          </div>
          <div className="burger-menu-icon" onClick={toggleBurgerMenu}>
            {burgerOpen ? <FiX /> : <FiMenu />}
          </div>
        </div>
      </nav>
      {burgerOpen && (
        <div className="burger-menu-overlay">
          <div className="burger-menu">
            <div className="burger-menu-header">
              <img src={Logo} alt="SafeRent Logo" className="home-logo" />
              <div className="burger-menu-icon" onClick={toggleBurgerMenu}>
                <FiX />
              </div>
            </div>
            <ul>
              <li><Link to="/signin">Sign In</Link></li>
              <li><Link to="/signup">Discover SafeRent</Link></li>
              <li><Link to="/about">About SafeRent</Link></li>
            </ul>
            <div className="burger-social-icons">
              <a href="https://facebook.com"><FaFacebookF /></a>
              <a href="https://linkedin.com"><FaLinkedinIn /></a>
              <a href="https://instagram.com"><FaInstagram /></a>
              <a href="https://tiktok.com"><FaTiktok /></a>
              <a href="https://youtube.com"><FaYoutube /></a>
            </div>
          </div>
        </div>
      )}
      <div className="home-hero">
        <video autoPlay loop muted className="home-video">
          <source src={Video} type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div className="overlay"></div>
        <div className="home-logo-center">
          <img src={Logo} alt="SafeRent Logo" className="logo-center" />
        </div>
        <div className="home-buttons">
          <Link to="/signin" className="btn btn-signin">Sign In</Link>
          <Link to="/signup" className="btn btn-signup">Discover SafeRent</Link>
        </div>
      </div>
    </div>
  );
};

export default Home;