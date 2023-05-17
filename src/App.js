import './App.css';
import { createBrowserRouter,Outlet, createRoutesFromElements, Route, RouterProvider } from 'react-router-dom';
//layout import 
import Sidebar from './layouts/sidebar/Sidebar';

//pages import 
import PostLibrary from './pages/PostLibrary';
import Campagns from './pages/Campagns';
import Campagns_posts from './pages/Campagns_posts';
import Post_statistique from './pages/Post_statistique';
import Posts_lanifier from './pages/Posts_lanifier';
import Create_post from './pages/Create_post';

const router = createBrowserRouter(
  createRoutesFromElements(
    <Route
      path="/"
      element={ <Sidebar />}>
      <Route path=':page_name' >
        {/* <Route index element={<Outlet/>}/> */}
      <Route path="postlibrary"  >
        <Route index element={<PostLibrary />}/> 
        <Route path=":post_id" element={<Post_statistique/>}/>
      </Route>

      <Route path="campagns">
        <Route index element={<Campagns />}/>
        <Route path=":campagn_id"  >
          <Route index element={<Campagns_posts/>}/>
          <Route path=":post_id" element={<Post_statistique/>} />
        </Route>
        </Route>



    <Route path="schedule">
        <Route index element={<Posts_lanifier />}/>
        <Route path="create" element={<Create_post/>} />
        create
        </Route> 
      </Route>




    </Route>
  




  )
);
function App() {
  return (
    <RouterProvider router={router}/>

  );
}

export default App;
