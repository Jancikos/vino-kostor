import React from "react";

export function Link(props) {
    return (
        <div className="link">
            {props.iconBefore ?? ""}
            <a href={props.href} target={props.target ?? "_blank"}>
                {props.title}
            </a>
            {props.iconAfter ?? ""}
        </div>
    );
}