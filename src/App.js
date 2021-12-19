import React from "react";

import { Header } from "./sections/header/Header.js";
import { Showcase } from "./sections/showcase/Showcase.js";
import { Contact } from "./sections/contact/Contact.js";
import "./css/app.css"

export class App extends React.Component{
    render() {
        return(
            <div style={{height: "100%"}}>
                <Header  />
                <Showcase />
                <Contact />
                {/*
                 // kontakt
                // recencie
                // mapa
                // pata */}
            </div>
        );
    }
}

// export const App = () => App();