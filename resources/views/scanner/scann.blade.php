
<html>
    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <form action="{{url('scann ')}}" method="POST">
                        {{ csrf_field()}}
                       <p style="text-align:center; margin-top:110px;"> <label>SCAN QR  CODE</label></p>
                        {{-- <input type="text" name="text" id="text" readonyy="" placeholder="scan qrcode" class="form-control"> --}}
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div><br><br>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <video id="preview" width="100%"></video>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>


        <script>
           const listEmploye = <?php echo json_encode($employes); ?>;
           let lastScan;
           let lastScanValue;

            console.log(listEmploye);

           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(qrCodeValueGot){
               //document.getElementById('text').value=c;
               //document.forms[0].submit();

               qrCodeValue = qrCodeValueGot;
               _treatScanQrCode(qrCodeValueGot);
           });

           let qrCodeValue ="";
           const _treatScanQrCode = async (qrCode) =>
           {
                let found = false;
                let currentEmploye;
                let newDate = new Date();
                let currentDate = newDate.getDate()+'-'+(newDate.getMonth()+1)+'-'+newDate.getFullYear()+' "à" '+newDate.getHours()+':'+newDate.getMinutes()+':'+newDate.getSeconds()
                for(let index = 0; index < listEmploye.length; index++)
                {
                    if(qrCode.toLowerCase().includes(listEmploye[index].email.toLowerCase()))
                    {
                        currentEmploye = listEmploye[index];
                        found = true;
                        break;
                    }
                }

                if(found)
                {
                    lastScan = await _getEmployeTodayScanHistory(currentEmploye);
                    console.log("Last scan",lastScan)
                    Swal.fire({
                        title: `Bonjour/Bonsoir ${currentEmploye.nom} ${currentEmploye.prenom}`,
                        text: `Vous avez scanné votre code le ${currentDate}. Veuillez valider pour continuer`,
                        icon: 'success',
                        //showConfirmButton:false,
                        confirmButtonText: 'ARRIV&Eacute;E',
                        showDenyButton:true,
                        denyButtonText:'D&Eacute;PART',
                    }).then(response =>{
                        if(response.isConfirmed) // Choix Arrivée
                        {
                            // Traitement si l'employé confirme le scan pour l'arrivée
                            // Traitement sur l'historique
                            let actualDate = new Date();

                            if(lastScan.length > 0) // Initialisation : si il existe un historique
                            {
                                let correctOperation = _checkDateOperation(lastScanValue,actualDate)

                                if(!correctOperation) 
                                    _forbidenScanOperation();
                                else
                                {
                                    _addScanHistory(currentEmploye,'addHistoryArrival');
                                    _scanOperationSuccess();
                                }
                            }
                            else // Tout premier scan, on passe directement à l'enregistrement
                            {
                                _addScanHistory(currentEmploye,'addHistoryArrival');
                                _scanOperationSuccess();
                            }
                            
                        }
                        else
                        {
                            if(response.isDenied) // Choix : Départ
                            {
                                // Traitement si l'employé confirme le scan pour l'arrivée
                                // Traitement sur l'historique
                                let actualDate = new Date();

                                if(lastScan.length > 0) // Initialisation : si il existe un historique
                                {
                                    let correctOperation = _checkDateOperation(lastScanValue,actualDate)

                                    if(!correctOperation)  
                                        _forbidenScanOperation();
                                    else
                                    {
                                        _addScanHistory(currentEmploye,'addHistoryDeparture');
                                        _scanOperationSuccess();
                                    }
                                }
                                else // Tout premier scan, on passe directement à l'enregistrement
                                {
                                    _addScanHistory(currentEmploye,'addHistoryArrival');
                                    _scanOperationSuccess();
                                }                               
                            }
                            else
                                Swal.fire({
                                    icon:'infos',
                                    title:'Procédure non complétée, veuillez reéssayer'
                                })
                        }
                    })
                }                    
                else
                    Swal.fire({
                            title: 'Bonjour/Bonsoir',
                            text: `Ooops... Vous n’êtes pas autorisé à scanner`,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
           }

           const _scanOperationSuccess = () => {
                Swal.fire({
                    title: 'Bonjour/Bonsoir',
                    text: `Opération effectuée avec succès`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
           }

           const _forbidenScanOperation = () => {
                Swal.fire({
                    title: 'Bonjour/Bonsoir',
                    text: `Vous n'êtes pas autorisé à scanner pour le moment`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
           }

           const _getEmployeTodayScanHistory = (currentEmploye) => {
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                       console.log(xhttp.responseText);
                       lastScan = xhttp.responseText;
                       lastScan.length > 5 ? lastScanValue = JSON.parse(lastScan.substring(1,(lastScan.length - 1))) : lastScanValue = {};
                       console.log(lastScanValue);
                       return;
                    }
                };
                xhttp.open("GET", "{{url('scanner')}}?email="+currentEmploye.email+"&action=getHistory", true);
                xhttp.send();
           }

           const _addScanHistory = (currentEmploye,action)  => {
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                       return xhttp.responseText;
                    }
                };
                xhttp.open("GET", "{{url('scanner')}}?email="+currentEmploye.email+"&action="+action, true);
                xhttp.send();
           }

           const _checkDateOperation = (lastScanValue, currentDate) => {
                console.log(lastScanValue);
                let scanFullDate = new Date(lastScanValue.created_at.split(0))

                console.log("Différence de dates",scanFullDate.getTime()-currentDate.getTime())

                return true;
           }

        </script>

        
    </body>
</html>