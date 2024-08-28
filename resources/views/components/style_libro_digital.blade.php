<style {{ $attributes }}>

    .card {
        /*margin-top: 2em;*/
        padding: 0.5em;
        border-radius: 2em;
        /*text-align: center;*/
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .card .card-header {

        padding: 0.5em;
        border-top-left-radius: 2em;
        border-top-right-radius: 2em;
        /*text-align: center;*/
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }


    .card li {
        list-style: none;
    }

    .card_img {
        /*width: 65%;*/
        /*border-radius: 50%;*/
        border-radius: 2em;
        margin: 0 auto 0 -50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background: #1a1e21;
        color: white;
        font-size: 6em;
        font-weight: bold;
    }

    .card .card-title {
        font-weight: 700;
        font-size: 1.5em;
    }

    /*.card .btn {*/
    /*    border-radius: 2em;*/
    /*    background-color: teal;*/
    /*    color: #ffffff;*/
    /*    padding: 0.5em 1.5em;*/
    /*}*/

    .card .btn:hover {
        background-color: rgba(0, 128, 128, 0.7);
        color: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .page-item {
        padding-left: 15px;
        padding-right: 15px;
        box-sizing: border-box;
    }
    .hover-effect:hover {
        background-color: #f5f5f5; /* Cambia el color de fondo al color que prefieras */
        box-shadow: 0 0 10px rgba(0,0,0,0.5); /* Agrega un efecto de sombra */
    }
    .zoom-effect {
        opacity: 1;
        transition: transform 0.2s, opacity 0.2s;
    }
    /* Cambia todos los elementos al hacer hover en el contenedor */
    .container:hover .zoom-effect {
        opacity: 0.5;
    }
    /* Aplica el efecto zoom y retorna la opacidad al elemento individual en hover */
    .container .zoom-effect:hover {
        transform: scale(1.1);
        opacity: 1;
    }

</style>
