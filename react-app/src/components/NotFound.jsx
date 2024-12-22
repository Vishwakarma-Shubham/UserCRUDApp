import React from 'react'
import { Link } from "react-router-dom";

function NotFound() {

    return (
        <h1 className='m-5 text-xl'>
            OPPS! Page not found go back to
            <Link className='pl-2 underline' to="/">List Users</Link>
        </h1>
    )
}

export default NotFound