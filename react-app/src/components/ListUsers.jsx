import React, { useEffect, useState } from 'react';
import { useNavigate } from "react-router-dom";
import Swal from 'sweetalert2';

function ListUsers() {

    const [users, setUsers] = useState([]);

    // Get All the user
    useEffect(() => {
        fetch('http://localhost/users')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            setUsers(data.data);
            } else {
            console.error('Failed to fetch users:', data.message);
            }
        })
        .catch(error => console.error('Error fetching users:', error));
    }, []);


    // Delete the user
    const deleteUser = (userId) => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`http://localhost/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        if(data.errors.length){
                            Swal.fire('Error!', data.errors, 'error');
                        } else {
                            Swal.fire('Deleted!', data.messsage, 'success');
                        }
                        setUsers(prevUsers => prevUsers.filter(user => user.id !== userId));

                    } else {
                        Swal.fire('Error!', data.messsage, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'There was an error with the server.', 'error');
                });
            }
        });
    };


    // To navigate through pages without reload
    const navigate = useNavigate();

    const handleEdit = (userId) => {
        Swal.fire({
            title: 'Are you sure you want to edit this user?',
            text: 'You can modify the user details.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, edit it!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                navigate(`/edituser/${userId}`);
            }
        });
    };

    return (
        <>
            <div className="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

            {users.length === 0 ? (
                <div className="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50" role="alert">
                    <svg className="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>No Records found!</div>
                </div>
                ) : (
                <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead className="text-xs text-white uppercase bg-gray-800">
                            <tr>
                                <th scope="col" className="px-6 py-3">Id</th>
                                <th scope="col" className="px-6 py-3">Name</th>
                                <th scope="col" className="px-6 py-3">Email</th>
                                <th scope="col" className="px-6 py-3">DOB</th>
                                <th scope="col" className="px-6 py-3 w-44">Action</th>
                                <th scope="col" className="px-3 py-3" align="center">
                                    <input type="checkbox" name="select_all" id="select_all" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {users.map((user) => (
                            <tr key={user.id}>
                                <td className="px-6 py-3">{user.id}</td>
                                <td className="px-6 py-3">{user.name}</td>
                                <td className="px-6 py-3">{user.email}</td>
                                <td className="px-6 py-3">{user.dob}</td>
                                <td className="px-6 py-4 w-44">
                                    <span>
                                        <button type="button" className="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 m-1" onClick={() => handleEdit(user.id)}>
                                            Edit
                                        </button>
                                        <button type="button" onClick={() => deleteUser(user.id)} className="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            Delete
                                        </button>
                                    </span>
                                </td>
                                <td className="px-6 py-3" align="center">
                                    <input type="checkbox" name={`user_${user.id}`} />
                                </td>
                            </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            </div>
        </>
    );
}

export default ListUsers;
