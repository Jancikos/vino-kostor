import React from "react";

import { Header } from "./sections/header/Header.js";
import { About } from "./sections/about/About.js";
import { Showcase } from "./sections/showcase/Showcase.js";
import { Landing } from "./sections/landing/Landing.js";
import { Contact } from "./sections/contact/Contact.js";
import { Footer } from "./sections/footer/Footer.js";
import { Map } from "./sections/contact/Map.js";
import "./css/app.css"
import { Products } from "./sections/products/Products.js";

export class App extends React.Component {
    render() {
        return (
            <div>
                <Header />
                <Landing />
                <About />
                <Products />
                <Contact />
                {/*
                // recenciedr
                // pata */}
                <Map/>
                <Footer />
            </div>
        );
    }
}

// export const App = () => App();