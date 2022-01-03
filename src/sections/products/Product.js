import React from "react";

import {MailLink} from "../../components/links/MailLink";
import {TelLink} from "../../components/links/TelLink";

export class Product extends React.Component {

    render(){
        return(
            <div className="productCard">
                {/* pre page navigatora */}
                <h2 className="hide"> {this.props.title} </h2> 
                
                <img src={this.props.photo}/>
                
                <p className="title">{this.props.title}</p>
                <small> {this.props.subtitle} </small>
                <span className="price">{this.props.price}</span>
            </div>
        )
    }
}