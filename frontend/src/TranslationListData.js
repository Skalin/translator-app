import { Box } from '@mui/system';
import { DataGrid, GridActionsCellItem, GridToolbarContainer, GridToolbarExportContainer } from '@mui/x-data-grid';
import { useEffect, useState, useCallback } from 'react';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import { useNavigate } from "react-router-dom";
import Container from '@mui/material/Container';
import CssBaseline from '@mui/material/CssBaseline';
import { Button, MenuItem, Typography } from '@mui/material';
import axios from 'axios';


export function TranslationListData() {
    const [page, setPage] = useState(0);
    const [pageSize, setPageSize] = useState(20);
    const [loading, setLoading] = useState(null)
    const [rowCount, setRowCount] = useState(0);
    const [data, setData] = useState([]);
    const [exportTypes, setExportTypes] = useState([]);
    const navigate = useNavigate();

    const loadData = () => {

        setLoading(true);
        axios.get('/translations', { params: { 'page': page + 1, 'per-page': pageSize } })
            .then((response) => { setData(response.data.items); setRowCount(response.data._meta.totalCount); setLoading(false) });  
        axios.get('/exports')
            .then((response) => { setExportTypes(response.data); setLoading(false) });
    }

    useEffect(() => {
        loadData()
    }, [page, pageSize])


    const addTranslation = (() => {
        navigate('/translation');
    })

    const deleteTranslation = useCallback((id) => () => {
        axios.delete(`/translations/${id}`).then(() => { loadData() })
    }, [])

    const doExport = useCallback((type) => () => {
        axios.get(`/exports/${type}`, {responseType: 'blob'})
            .then((response) => {
                var fileDownload = require('js-file-download');
                fileDownload(response.data, 'export.zip');
                setLoading(false);
            });
    }, [])

    const updateTranslation = useCallback((id) => () => {
        navigate(`/translation/${id}`)
    }, [])

    const CustomExportMenuItem = (props) => {
      
        return (
          <MenuItem onClick={doExport(props.type)}>
            Export do {props.type.toUpperCase()}
          </MenuItem>
        );
      };


    function CustomToolbar() {
        return (
            <GridToolbarContainer>
                <Button onClick={addTranslation}>Přidat překlad<AddIcon /></Button>
                <GridToolbarExportContainer>
                    {exportTypes.map((type) => {
                        return <CustomExportMenuItem key={type} type={type}/>
                    })}
                </GridToolbarExportContainer>
            </GridToolbarContainer>
        );
    }


    return (
        <>
            <Container>
                <CssBaseline />
                <Box
                    sx={{
                        marginTop: 8,
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                    }}
                >
                    <Typography variant="h2" component="h1">Překlady</Typography>

                    {(data && loading === false ?

                        <div style={{ display: "flex", width: '100%',  marginTop: '2em' }}>
                            <div style={{ flexGrow: 1 }}>
                                <DataGrid
                                    autoHeight
                                    components={{
                                        Toolbar: CustomToolbar,
                                    }}
                                    loading={loading}
                                    pagination
                                    rowCount={rowCount}
                                    page={page}
                                    pageSize={pageSize}
                                    paginationMode="server"
                                    onPageChange={(newPage) => setPage(newPage)}
                                    onPageSizeChange={(newPageSize) => setPageSize(newPageSize)}
                                    rows={data}
                                    columns={[
                                        {
                                            field: "key", headerName: "ID", flex:0.8 },
                                        {
                                            field: 'actions', align:'right', type: 'actions', flex: 0.2, getActions: (params) => [
                                            <GridActionsCellItem
                                                icon={<EditIcon />}
                                                label="Delete"
                                                onClick={updateTranslation(params.id)}
                                            />,
                                            <GridActionsCellItem
                                                icon={<DeleteIcon />}
                                                label="Delete"
                                                onClick={deleteTranslation(params.id)}
                                            />,
                                        ],
                                    }]} />
                            </div>
                        </div>

                        : "Loading...")}

                </Box>
            </Container>
        </>)
}