import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import reportWebVitals from './reportWebVitals';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import { TranslationUpdate } from './TranslationUpdate';
import { TranslationCreate } from './TranslationCreate';
import { Root } from './Root';
import { ErrorPage } from './ErrorPage';
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";
import { Button } from '@mui/material';
import api from './Api';


const router = createBrowserRouter([
  {
    path: "",
    element: <Root />,
    errorElement: <ErrorPage />,
  },
  {
    path: "translation/:translationId",
    element: <TranslationUpdate />,
  },
  {
    path: "translation/",
    element: <TranslationCreate />,
  }

]);

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>

    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="static">
        <Toolbar>
          <IconButton
            size="large"
            edge="start"
            color="inherit"
            aria-label="menu"
            sx={{ mr: 2 }}
          >
          </IconButton>
          <Button href="/">
            <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
              Translator App
            </Typography>
          </Button>
        </Toolbar>
      </AppBar>
    </Box>

    <RouterProvider router={router} />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
