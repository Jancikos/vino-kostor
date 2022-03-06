import React from "react";

import "../../css/header.css"

export class NavbarItem extends React.Component {
    render() {
        return (
            <li className={"navbar-item " + (this.props.active ? "active" : "")}>
                <a href={this.props.href}>{this.props.title}</a>
            </li>
        );
    }
}