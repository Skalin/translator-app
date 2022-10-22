import React from 'react';
import axios from "axios";
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Box from '@mui/material/Box';
import { Button, FormGroup, Grid, TextField, Typography } from '@mui/material';
import { Container } from '@mui/system';
import { useForm } from "react-hook-form";

export function TranslationCreate() {
    const [isLoading, setIsLoading] = useState(null)
    const [key, setKey] = useState(null)
    const navigate = useNavigate()
    const [errors, setErrors] = useState([])
    const [validated, setValidated] = useState(null)
    const { handleSubmit } = useForm({ reValidateMode: 'onSubmit' });

    const onSubmit = (data) => {

        setIsLoading(true)
        setErrors([]);
        axios.post('/translations', { key: key })
            .then(function () {
                setValidated(true);
                setIsLoading(false)
                navigate(`/translation/${key}`)
            })
            .catch((err) => {
                setIsLoading(false)
                setValidated(false);
                setErrors(err.response.data);
            })
    }




    /*
    const handleSubmit = (e, inputs) => {
        
    }

    */
    useEffect(() => {
        setIsLoading(false)
    }, [])

    const handleChange = (e) => {
        setKey(e.target.value);
        e.preventDefault();
    }

    if (!isLoading) {

        return (
            <>

                <Box sx={{
                    marginTop: 8,
                    alignItems: 'center',
                    '& .MuiTextField-root': { m: 1, width: '25ch' },
                    display: 'flex',
                    flexDirection: 'column',
                }}>
                    <Typography variant="h2" component="h1">Nový překlad</Typography>
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
                    onSubmit={handleSubmit(onSubmit)}
                >
                    <Container maxWidth="md" >
                        <Grid container
                            spacing={0}
                            rowSpacing={0}
                            alignItems="center"
                            justifyContent="center">
                            {
                                <FormGroup sx={{ alignItems: "center" }}>
                                    {errors.map((o)  => {if (o.field === 'key') return (<Typography>{o.message}</Typography>); return null })}
                                    <TextField id="key" onChange={handleChange} name="key" label={"Název"} />
                                </FormGroup>
                            }
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