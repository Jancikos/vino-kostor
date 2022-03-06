import React from "react";

import { JumpToLink } from "../../components/links/JumpToLink";
import '../../css/landing.css';

export class Landing extends React.Component {

    render() {
        return (
            <div id="landing">
                <JumpToLink link="#aboutSection" />                
            </div>
        )
    }
}