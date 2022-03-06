import React from "react";

import {MailLink} from "../../components/links/MailLink";
import {TelLink} from "../../components/links/TelLink";

export class ContactPerson extends React.Component {

    render(){
        return(
            <div className="contactPerson">
                {/* pre page navigatora */}
                <h2 className="hide"> {this.props.name} </h2> 
                
                <img className="shadow" src={this.props.photo} alt={this.props.name}/>
                
                <div className="text">
                    <p className="title"> {this.props.name} </p>
                    <small> {this.props.subtitle} </small>
                    <p className="motto" style={{fontSize: "var(--step-" + (this.props.motto.length < 60 ? "4" : "2") + ")"}}>{ this.props.motto }</p>
                    <div className="links">
                        {this.props.phone ? (<TelLink number={this.props.phone} />) : ""}        
                        {this.props.email ? (<MailLink title={this.props.email} />) : ""}        
                    </div>
                </div>
            </div>
        )
    }
}