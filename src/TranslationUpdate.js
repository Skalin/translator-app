import React from 'react';
import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import Box from '@mui/material/Box';
import { Button, FormGroup, Grid, TextField, Typography } from '@mui/material';
import { Container } from '@mui/system';
import axios from 'axios';

export function TranslationUpdate() {
    const { translationId } = useParams(null)
    const [isLoading, setIsLoading] = useState(null)
    const [data, setData] = useState(null)
    const navigate = useNavigate()


    const loadData = () => {

        setIsLoading(true);
        axios.get(`/translations/${translationId}`)
            .then(function (response) { setData(response.data); setIsLoading(false) })
    }
    useEffect(() => {
        loadData()
    }, [])

    const handleSubmit = (e, inputs) => {
        setIsLoading(true)
        axios.patch(`/translations/${translationId}`, data)
            .then(function (response) {
                setIsLoading(false)
                navigate('/')
            })
            .catch((err) => {
                setIsLoading(false)
                navigate('/error', err)
            })
        e.preventDefault();
    }

    const handleChange = (e) => {
        const translations = data.translations
        translations.find((o, i) => {
            if (o.lang === e.target.name) {
                translations[i].translation = e.target.value;
            }
        })
        setData(data);
        e.preventDefault();
    }

    if (!isLoading && data && data.translations) {

        return (
            <>

                <Box sx={{
                    marginTop: 8,
                    alignItems: 'center',
                    '& .MuiTextField-root': { m: 1, width: '25ch' },
                    display: 'flex',
                    flexDirection: 'column',
                }}>
                    <Typography variant="h2" component="h1">Překlad {data.key}</Typography>
                </Box>
                <Box
                    component="form"
                    sx={{
                        '& .MuiTextField-root': { m: 1, width: '25ch' },
                        marginTop: 8,
                        display: 'flex',
                        flexDirection: 'row',
                        alignItems: 'center',
                    }}
                    onSubmit={handleSubmit}
                >
                    <Container maxWidth="md" >
                        <Grid container
                            spacing={0}
                            rowSpacing={0}
                            alignItems="center"
                            justifyContent="center">
                            {data.translations.map((translation) => {
                                return (<Grid item xs={4} key={translation.lang}>
                                    <FormGroup  sx={{alignItems:"center"}}>
                                        <TextField id={translation.lang} onChange={handleChange} name={translation.lang} defaultValue={translation.translation} label={"Jazyk: "+translation.lang} />
                                    </FormGroup>
                                </Grid>)
                            })}
                        </Grid>
                        <Grid container
                            spacing={0}
                            rowSpacing={0}
                            alignItems="center"
                            justifyContent="center">
                            <Grid item xs={3}>
                                <FormGroup>
                                    <Button variant="outlined" size="medium" type="submit">Uložit</Button>
                                </FormGroup>
                            </Grid>
                        </Grid>
                    </Container>
                </Box>
            </>
        )

    }
    else {
        return (
            "Loading..."
        )
    }
}