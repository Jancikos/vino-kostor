import React from "react";

import "../../css/showcase.css"

export class ShowcaseItem extends React.Component{

    render(){
        return (
            <div className={"showcaseItem " + this.props.image}>
                <div className="showcaseDescription">
                    <p className="showcaseTitle"> {this.props.title} </p>
                    <p className="showcaseText"> {this.props.text} </p>
                </div>
            </div>
        );
    }
}