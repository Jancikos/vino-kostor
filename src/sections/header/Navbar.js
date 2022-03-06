import React from "react";

import { NavbarItem } from './NavbarItem';

import "../../css/header.css"

export class Navbar extends React.Component {
    state = {
        navItems: []
    }

    componentDidMount = () => {
        // tu pridat logiku dynamicky pridaveych bavbar itemov
        const sections = [];
        
        let i = this.state.navItems.length;
        document.querySelectorAll('.section').forEach(section => {
            sections.push((<NavbarItem key={i} title={section.getAttribute("data-nav-title")} href={section.getAttribute("data-href")} />));
            i++;
        });

        this.setState({
            navItems: sections
        });
    }

    render() {
        return (
            <div id="navbar">
                <nav id="desktop-navbar">
                    { this.state.navItems }
                </nav>
            </div>
        );
    }
}