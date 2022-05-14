var app = new Vue({
    el: '#vue-container',
    data: {

    },
    mounted(){
        console.log("Vue funziona");



    },
    methods: {
        inviaRichiesta()
        {
            
        },
        compariAlertErrore($stringa)
        {
            $.bootstrapGrowl($stringa,{
                ele: "body",
                type: "danger",
                offset: {from:"top", amount:10},
                align: "right",
                delay: 2000,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
        compariAlertSuccess($stringa)
        {
            $.bootstrapGrowl($stringa,{
                ele: "body",
                type: "success",
                offset: {from:"top", amount:10},
                align: "right",
                delay: 1500,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
    }
});
