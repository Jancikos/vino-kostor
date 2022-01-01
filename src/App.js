import React from "react";

import { Header } from "./sections/header/Header.js";
import { About } from "./sections/about/About.js";
import { Showcase } from "./sections/showcase/Showcase.js";
import { Landing } from "./sections/landing/Landing.js";
import { Contact } from "./sections/contact/Contact.js";
import { Footer } from "./sections/footer/Footer.js";
import "./css/app.css"

export class App extends React.Component {
    render() {
        return (
            <div style={{ height: "100%" }}>
                <Header />
                <Landing />
                <About />
                <Contact />
                {/*
                // recencie
                // pata */}
                <Footer />
            </div>
        );
    }
}

// export const App = () => App();