import { createBrowserRouter, RouterProvider } from 'react-router-dom';

import NavBar from './components/NavBar';
import ListUsers from './components/ListUsers';
import AddUser from './components/AddUser';
import EditUser from './components/EditUser';
import NotFound from './components/NotFound';

const router = createBrowserRouter([
    {
        path: "/",
        element: (
            <div className="min-h-full">
                <NavBar />
                <ListUsers />
            </div>
        ),
    },
    {
        path: "/adduser",
        element: (
            <div className="min-h-full">
                <NavBar />
                <AddUser />
            </div>
        ),
    },
    {
        path: "/edituser/:id",
        element: (
            <div className="min-h-full">
                <NavBar />
                <EditUser />
            </div>
        ),
    },
    {
        path: "*",
        element: (
            <div className="min-h-full">
                <NavBar />
                <NotFound />
            </div>
        ),
    },
]);

function App() {

  return (
    <>
        <RouterProvider router={router}>
        </RouterProvider>
    </>
  )
}

export default App
