// src/pages/SignupPage.js
import React from 'react';
import LeftSectionSignup from '../components/LeftSectionSignup';
import RightSection from '../components/RightSection';
import './SignupPage.css';

const SignupPage = () => {
  return (
    <div className="signup-container">
      <LeftSectionSignup />
      <RightSection />
    </div>
  );
}

export default SignupPage;
