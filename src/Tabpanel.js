
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import { useEffect, useState } from 'react';
import axios from 'axios';


export function TabPanel(props) {
    const { children, value, ...other } = props;
    const [translations, setTranslations] = useState([]);
    const [loading, setLoading] = useState(null);
  

    const loadData = () => {
        setLoading(true);
        axios.get(`/langTranslations/${value.shortcut}`)
            .then(function (response) {setTranslations(response.data); setLoading(false);})
            .then()
    }

    useEffect(() => {
        loadData();
    }, [])

    return (
      <div
        role="tabpanel"
        id={`simple-tabpanel`}
        aria-labelledby={`simple-tab`}
        {...other}
      >
        {(
          <Box sx={{ p: 3 }}>
            <Typography>{children}</Typography>
          </Box>
        )}
      </div>
    );
  }