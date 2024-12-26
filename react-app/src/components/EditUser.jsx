import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { useParams } from 'react-router-dom';
import Swal from 'sweetalert2';

function EditUser() {

    const { id } = useParams();

    const { register, handleSubmit, setValue, formState: { errors } } = useForm();
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchUserData = async () => {
            try {
                const response = await fetch(`http://192.168.0.12:8080/users/${id}`);
                const data = await response.json();

                if (data.success && data.data) {
                    const { name, email, dob } = data.data;

                    // Pre-fill the form fields
                    setValue('name', name);
                    setValue('email', email);
                    setValue('dob', dob);

                    setLoading(false);
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.errors || 'Failed to load user data',
                        icon: 'error',
                    });
                    setLoading(false);
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to fetch user data. Please try again.',
                    icon: 'error',
                });
                setLoading(false);
            }
        };

        fetchUserData();
        
    }, [id, setValue]);

    const onSubmit = async (formData) => {
        try {
            const response = await fetch(`http://192.168.0.12:8080/users/${id}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
      				'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    title: 'Success',
                    text: data.messsage,
                    icon: 'success',
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.errors,
                    icon: 'error',
                });
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
            });
        }
    };

    if (loading) {
        return <div className="text-center mt-6">Loading user data...</div>;
    }

    return (
        <div className="max-w-lg mt-6 mx-auto p-4 bg-white shadow-md rounded-lg">
            
            <h1 className="text-xl font-bold mb-4">Edit User</h1>
            
            <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700" htmlFor="name">
                        Name
                    </label>
                    <input type="text" id="name"
                        {...register('name', { required: 'Name is required' })}
                        className="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    {errors.name && <span className="text-red-500 text-sm">{errors.name.message}</span>}
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700" htmlFor="email">
                        Email
                    </label>
                    <input type="email" id="email"
                        {...register('email', {
                                required: 'Email is required',
                                pattern: {
                                    value: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: 'Invalid email format',
                                },
                            })
                        }
                        className="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    {errors.email && <span className="text-red-500 text-sm">{errors.email.message}</span>}
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700" htmlFor="password">
                        Password
                    </label>
                    <input type="password" id="password"
                        {...register('password', {
                                minLength: { 
                                    value: 6, message: 'Password must be at least 6 characters' 
                                },
                            })
                        }
                        className="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    {errors.password && <span className="text-red-500 text-sm">{errors.password.message}</span>}
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700" htmlFor="dob">
                        Date of Birth
                    </label>
                    <input type="date" id="dob"
                        {...register('dob', { required: 'Date of Birth is required' })}
                        className="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    {errors.dob && <span className="text-red-500 text-sm">{errors.dob.message}</span>}
                </div>

                <div>
                    <button type="submit" className="w-full px-4 py-2 text-white bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-2">
                        Submit
                    </button>
                </div>

            </form>

        </div>
    );
}

export default EditUser;
