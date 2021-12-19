import React from "react";

import {MailLink} from "../../components/links/MailLink";
import {TelLink} from "../../components/links/TelLink";

export class ContactPerson extends React.Component {

    render(){
        return(
            <div className="contactPerson">
                <img src={this.props.photo}/>
                <h2> {this.props.name} </h2>
                <small> {this.props.subtitle} </small>
                <div>
                    {this.props.phone ? (<TelLink number={this.props.phone} />) : ""}        
                    {this.props.email ? (<MailLink title={this.props.email} />) : ""}        
                </div>
            </div>
        )
    }
}