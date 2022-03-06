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
    state = {
        headerOpacity: 0.75
    }
    
    
    componentDidMount = () => {
        window.addEventListener('scroll', this.handleScroll);
        // this.handleScroll();
    };

    handleScroll = () => {
        if(!this.state.scrollRef){
            return;
        }

        let opacity = this.state.headerOpacity;
        const { top } = this.state.scrollRef.getBoundingClientRect();

        if(top < -100){
            opacity = 0.80;
        }

        if(top < -200){
            opacity = 0.90;
        }

        if(top < -300){
            opacity = 1;
        }


        this.setState({
            headerOpacity: opacity
        })
    
    }

    setWrapRef = ref => {
        this.setState({
            scrollRef: ref
        });
    }

    render() {
        return (
            <div>
                <Header opacity={this.state.headerOpacity}/>
                <Landing setRef={this.setWrapRef}/>
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