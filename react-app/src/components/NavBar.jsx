import React from 'react'
import { NavLink } from 'react-router-dom'

import TailwindSVG from '../assets/tailwind-logo.svg'

function NavBar() {
  return (
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8" src={TailwindSVG}/>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <NavLink className={({isActive}) => isActive ? "bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" : "text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"} to="/">List User</NavLink>
                            <NavLink className={({isActive}) => isActive ? "bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" : "text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"} to="/adduser">Add User</NavLink>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <NavLink className={({isActive}) => isActive ? "bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" : "text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"} to="/">List User</NavLink>
                <NavLink className={({isActive}) => isActive ? "bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" : "text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"} to="/adduser">Add User</NavLink>
            </div>
        </div>
    </nav>
  )
}

export default NavBar
