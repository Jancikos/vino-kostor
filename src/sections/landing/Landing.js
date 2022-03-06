import React from "react";

import { JumpToLink } from "../../components/links/JumpToLink";
import '../../css/landing.css';

export class Landing extends React.Component {

    render() {
        return (
            <div id="landing" ref={this.props.setRef}>
                <JumpToLink link="#about" />                
            </div>
        )
    }
}