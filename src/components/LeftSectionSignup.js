// src/components/LeftSectionSignup.js
import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
// Suppression des importations inutilisées
import { auth, signInWithGoogle, signInWithFacebook } from "../FirebaseConfig";
import { createUserWithEmailAndPassword } from "firebase/auth";
import { doc, setDoc } from "firebase/firestore";
import { db } from "../FirebaseConfig";
import "./LeftSectionSignup.css";

const LeftSectionSignup = () => {
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const navigate = useNavigate();

  const handleSignUp = async (e) => {
    e.preventDefault();

    if (password !== confirmPassword) {
      alert("Passwords do not match");
      return;
    }

    try {
      const userCredential = await createUserWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;

      await setDoc(doc(db, "users", user.uid), {
        firstName,
        lastName,
        email,
        phone,
        role: "user" // Attribue le rôle 'user' par défaut
      });

      navigate("/");
    } catch (error) {
      console.error("Error signing up: ", error);
    }
  };

  return (
    <div className="left-section-signup">
      <h1>Get started</h1>
      <p>Create your account to continue</p>
      <form className="signup-form" onSubmit={handleSignUp}>
        <div className="name-container">
          <div className="name-field">
            <label htmlFor="first-name">First Name</label>
            <input
              type="text"
              id="first-name"
              placeholder="First Name"
              required
              value={firstName}
              onChange={(e) => setFirstName(e.target.value)}
            />
          </div>
          <div className="name-field">
            <label htmlFor="last-name">Last Name</label>
            <input
              type="text"
              id="last-name"
              placeholder="Last Name"
              required
              value={lastName}
              onChange={(e) => setLastName(e.target.value)}
            />
          </div>
        </div>
        <label htmlFor="email">Email</label>
        <input
          type="email"
          id="email"
          placeholder="Example@email.com"
          required
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <label htmlFor="phone">Phone Number</label>
        <input
          type="tel"
          id="phone"
          placeholder="+1 234 567 890"
          required
          value={phone}
          onChange={(e) => setPhone(e.target.value)}
        />
        <label htmlFor="password">Password</label>
        <input
          type="password"
          id="password"
          placeholder="********"
          required
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <label htmlFor="confirm-password">Confirm Password</label>
        <input
          type="password"
          id="confirm-password"
          placeholder="********"
          required
          value={confirmPassword}
          onChange={(e) => setConfirmPassword(e.target.value)}
        />
        <div className="checkbox-container">
          <input type="checkbox" id="terms" required />
          <label htmlFor="terms">
            I accept the <a href="#">terms and conditions</a>
          </label>
        </div>
        <div className="checkbox-container">
          <input type="checkbox" id="privacy" required />
          <label htmlFor="privacy">
            I accept the <a href="#">privacy policy</a>
          </label>
        </div>
        <button type="submit" className="sign-up-button">
          Continue
        </button>
      </form>
      <p className="sign-up-text">
        Already have an account? <Link to="/">Sign in</Link>
      </p>
    </div>
  );
};

export default LeftSectionSignup;
