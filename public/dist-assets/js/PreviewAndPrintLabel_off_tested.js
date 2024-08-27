//----------------------------------------------------------------------------
//
//  $Id: PreviewAndPrintLabel.js 11419 2010-04-07 21:18:22Z vbuzuev $ 
//
// Project -------------------------------------------------------------------
//
//  DYMO Label Framework
//
// Content -------------------------------------------------------------------
//
//  DYMO Label Framework JavaScript Library Samples: Preview and Print label
//
//----------------------------------------------------------------------------
//
//  Copyright (c), 2010, Sanford, L.P. All Rights Reserved.
//
//----------------------------------------------------------------------------


(function () {
    // stores loaded label info
    var label;
    var labels=[];
    var _printers = [];
    var cansole;

    function createPrintersTableRow(table, name, value) {
        var row = document.createElement("tr");

        var cell1 = document.createElement("td");
        cell1.appendChild(document.createTextNode(name + ': '));

        var cell2 = document.createElement("td");
        cell2.appendChild(document.createTextNode(value));

        row.appendChild(cell1);
        row.appendChild(cell2);

        table.appendChild(row);
    }

    function populatePrinterDetail() {
        var printerDetail = document.getElementById("printerDetail");
        printerDetail.innerHTML = "";

        var myPrinter = _printers[document.getElementById("printersSelect").value];
        if (myPrinter === undefined)
            return;

        var table = document.createElement("table");
        createPrintersTableRow(table, 'PrinterType', myPrinter['printerType'])
        createPrintersTableRow(table, 'PrinterName', myPrinter['name'])
        createPrintersTableRow(table, 'ModelName', myPrinter['modelName'])
        createPrintersTableRow(table, 'IsLocal', myPrinter['isLocal'])
        createPrintersTableRow(table, 'IsConnected', myPrinter['isConnected'])
        createPrintersTableRow(table, 'IsTwinTurbo', myPrinter['isTwinTurbo'])

        dymo.label.framework.is550PrinterAsync(myPrinter.name).then(function (isRollStatusSupported) {
            //fetch one consumable information in the printer list.
            if (isRollStatusSupported) {
                createPrintersTableRow(table, 'IsRollStatusSupported', 'True')
                dymo.label.framework.getConsumableInfoIn550PrinterAsync(myPrinter.name).then(function (consumableInfo) {
                    createPrintersTableRow(table, 'SKU', consumableInfo['sku'])
                    createPrintersTableRow(table, 'Consumable Name', consumableInfo['name'])
                    createPrintersTableRow(table, 'Labels Remaining', consumableInfo['labelsRemaining'])
                    createPrintersTableRow(table, 'Roll Status', consumableInfo['rollStatus'])
                }).thenCatch(function (e) {
                    createPrintersTableRow(table, 'SKU', 'n/a')
                    createPrintersTableRow(table, 'Consumable Name', 'n/a')
                    createPrintersTableRow(table, 'Labels Remaining', 'n/a')
                    createPrintersTableRow(table, 'Roll Status', 'n/a')
                })
            } else {
                createPrintersTableRow(table, 'IsRollStatusSupported', 'False')
            }
        }).thenCatch(function (e) {
            createPrintersTableRow(table, 'IsRollStatusSupported', e.message)
        })

        printerDetail.appendChild(table);
    }

    function first(str) {
        const words = str.split(' ');
        // Counter for printed lines
        let linesPrinted = 0;
        // Iterate over the words array
        for (let i = 0; i < words.length && linesPrinted < 2; i += 3) {
            // Get the next three words, join them with a space, and log them
            // Increment the lines printed counter
            linesPrinted++;
        }
        return words.slice(0, 0 + 3).join(' ');
    }
    function second(str) {
        const words = str.split(' ');
        // Counter for printed lines
        let linesPrinted = 0;
        // Iterate over the words array
        for (let i = 0; i < words.length && linesPrinted < 2; i += 4) {
            // Get the next three words, join them with a space, and log them
            // Increment the lines printed counter
            linesPrinted++;
        }
        return words.slice(3, 3 + 4).join(' ');
    }
    function truncateString(str, start, maxLength) {
        if (str.length > start + maxLength) {
          return str.substring(start, start + maxLength) + '';
          
        } else {
          return str.substring(start);
          
        }
      }
    // called when the document completly loaded
    function onload() {
        var labelFile = document.getElementById('labelFile');
        var addressTextArea = document.getElementById('addressTextArea');
        var printersSelect = document.getElementById('printersSelect');
        var printButton = document.getElementById('printButton');

        function check_radio() {

            if (document.getElementById('labelFormatSmall').checked || document.getElementById('labelFormatClub').checked || document.getElementById('labelFormatClubSale').checked) {

            } else {
                alert('Checked First');
            }
            if (document.getElementById('labelFormatSmall').checked) {
                // alert('small');
                loadLabelFromWeb();
            } else if (document.getElementById('labelFormatClub').checked) {
                // alert('club');
                loadLabelFromWeb();
            } else if (document.getElementById('labelFormatClubSale').checked) {
                // alert('club sale');
                
                loadLabelFromWeb();
            }

        }
        display();
        function display() {

            var labelFormatSmall = document.getElementById('labelFormatSmall');
            labelFormatSmall.addEventListener('change', function () {
                if (this.checked) {
                    // Show an alert
                    alert('Radio button is checked!');
                    setTimeout(loadLabelFromWeb,1000);

                    //loadLabelFromWeb();
                }
            });

            var labelFormatClub = document.getElementById('labelFormatClub');
            labelFormatClub.addEventListener('change', function () {
                if (this.checked) {
                    // Show an alert
                    alert('Radio button is checked!');
                    setTimeout(loadLabelFromWeb,1000);
                    //loadLabelFromWeb();
                }
            });

            var labelFormatClubSale = document.getElementById('labelFormatClubSale');
            labelFormatClubSale.addEventListener('change', function () {
                if (this.checked) {
                    // Show an alert
                    alert('Radio button is checked!');
                    setTimeout(loadLabelFromWeb,1000);
                    //loadLabelFromWeb();
                }
            });

        }


        // initialize controls
        printButton.disabled = false;
        addressTextArea.disabled = true;

        // Generates label preview and updates corresponend <img> element
        // Note: this does not work in IE 6 & 7 because they don't support data urls
        // if you want previews in IE 6 & 7 you have to do it on the server side
        function updatePreview() {
            if (!label)
                return;

                var pngData = label.render();
                //var labelImage = document.getElementById('labelImage');
               var fileData = "data:image/png;base64," + pngData;
                let newDocument = document.createElement("li");
                newDocument.setAttribute(
                    "class",
                    "prev-file"
                  );
                  newDocument.innerHTML = `<img src="${fileData}">`;
                  prevsList.append(newDocument); 
                
                // var pngData = label.render();
                // var labelImage = document.getElementById('labelImage');
                // labelImage.src = "data:image/png;base64," + pngData;
           // var img = document.getElementsByTagName('img');
            // var id = document.getElementsByClassName("srlno");
            // if (id.length > 0) {
                
            //           let prevsList = document.querySelector("#prevsList");
            //            for (let i = 0; i < id.length; i++) 
            //            {
            //             var pngData = label.render();
            //             //var labelImage = document.getElementById('labelImage');
            //            var fileData = "data:image/png;base64," + pngData;
            //             let newDocument = document.createElement("li");
            //             newDocument.setAttribute(
            //                 "class",
            //                 "prev-file"
            //               );
            //               newDocument.innerHTML = `<img src="${fileData}">`;
            //               prevsList.append(newDocument);
            //            }}
        }

        // loads all supported printers into a combo box 
        // function loadPrinters() {
        //     var printers = dymo.label.framework.getPrinters();
        //     if (printers.length == 0) {
        //         alert("No DYMO printers are installed. Install DYMO printers.");
        //         return;
        //     }

        //     for (var i = 0; i < printers.length; i++) {
        //         var printer = printers[i];
        //         if (printer.printerType == "LabelWriterPrinter") {
        //             var printerName = printer.name;

        //             var option = document.createElement('option');
        //             option.value = printerName;
        //             option.appendChild(document.createTextNode(printerName));
        //             printersSelect.appendChild(option);
        //         }
        //     }
        // }
        // loads all supported printers into a combo box 
        function loadPrintersAsync() {
            _printers = [];
            dymo.label.framework.getPrintersAsync().then(function (printers) {
                if (printers.length == 0) {
                    alert("No DYMO printers are installed. Install DYMO printers.");
                    return;
                }
                _printers = printers;
                printers.forEach(function (printer) {
                    let printerName = printer["name"];
                    let option = document.createElement("option");
                    option.value = printerName;
                    option.appendChild(document.createTextNode(printerName));
                    printersSelect.appendChild(option);
                });
                populatePrinterDetail();
            }).thenCatch(function (e) {
                alert("Load Printers failed: " + e);;
                return;
            });
        }
        // returns current address on the label 
        function getAddress() {
            if (!label || label.getAddressObjectCount() == 0)
                return "";

            return label.getAddressText(0);
        }

        // set current address on the label 
        function setAddress(address) {
            if (!label || label.getAddressObjectCount() == 0)
                return;

            return label.setAddressText(0, address);
        }


        // updates address on the label when user types in textarea field
        // addressTextArea.onkeyup = function () {
        //     if (!label) {
        //         alert('Load label before entering address data');
        //         return;
        //     }

        //     setAddress(addressTextArea.value);
        //     updatePreview();
        // }

        // prints the label
        printButton.onclick = function () {
            document.getElementById('prevsList').innerHTML='';
            check_radio();
            try {
                if (!label) {
                    alert("Load label before printing");
                    return;
                }

                //alert(printersSelect.value);
              console.log('=============',label,labels,labels.length);
                if(labels.length>0){
                    
                    for(i=0;i<labels.length;i++)
                    {
                        labels[i].print(printersSelect.value);
                        console.log('PPPPPPPPPPP',labels[i]);
                    }
                    labels=[];
                }else{
                    label.print(printersSelect.value);
                    console.log('DDDDDDDDDDDD',label);
                }
               // label.print(printersSelect.value);
                //label.print("unknown printer");
            }
            catch (e) {
                alert(e.message || e);
            }
        }
        printersSelect.onchange = populatePrinterDetail;

        // load printers list on startup
        loadPrintersAsync();
        //for Smart Card
       
       // const sm_id = [];
        function getAddressLabelXml() {
            console.log('small');
            // for (let i = 0; i < amount.length; i++) {
            //     console.log(amount[i]);
            //   }

            // var amount = document.getElementById('srlno').innerText;
            // var itemname = document.getElementById('itemname').innerText;
            // var barnumber = document.getElementById('barnumber').innerText;
            // var itemdescript = document.getElementById('itemdescript').innerText;
            // var itemcode = document.getElementById('itemcode').innerText;
            // var itemqty = document.getElementById('itemqty').innerText;
            let small_label_xml = [];
            var id = document.getElementsByClassName("srlno");
            if (id.length > 0) {
                
            
                       for (let i = 0; i < id.length; i++) 
                       {
                        
                            //alert ('srlno_'+id[i].value);
                           var amount = document.getElementById('srlno'+id[i].value).innerText;
                           var itemname = document.getElementById('itemname'+id[i].value).innerText;
                            var barnumber = document.getElementById('barnumber'+id[i].value).innerText;
                            var itemdescript = document.getElementById('itemdescript'+id[i].value).innerText;
                            var itemcode = document.getElementById('itemcode'+id[i].value).innerText;
                            var itemqty = document.getElementById('itemqty'+id[i].value).innerText;
                            alert(amount + '\n' + itemname + '\n' + barnumber + '\n' + itemdescript + '\n' + itemcode + '\n' + itemqty);
            //                 console.log(
            //     amount[i] + '\n' + itemname[i] + '\n' + barnumber[i] + '\n' + itemdescript[i] + '\n' + itemcode[i] + '\n' + itemqty[i]
            // );
                    // var testAddressLabelXml = '<?xml version="1.0" encoding="utf-8"?>\
                    //     <DieCutLabel Version="8.0" Units="twips">\
                    //         <PaperOrientation>Landscape</PaperOrientation>\
                    //         <Id>Address</Id>\
                    //         <PaperName>30252 Address</PaperName>\
                    //         <DrawCommands>\
                    //         <RoundRectangle X="0" Y="0" Width="3000" Height="5040" Rx="270" Ry="270" />\
                    //         </DrawCommands>\
                    //         <ObjectInfo>\
                    //                 <TextObject>\
                    //                     <Name>BarcodeText</Name>\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                     <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                     <LinkedObjectName></LinkedObjectName>\
                    //                     <Rotation>Rotation0</Rotation>\
                    //                     <IsMirrored>False</IsMirrored>\
                    //                     <IsVariable>False</IsVariable>\
                    //                     <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                     <VerticalAlignment>Top</VerticalAlignment>\
                    //                     <TextFitMode>AlwaysFit</TextFitMode>\
                    //                     <UseFullFontHeight>False</UseFullFontHeight>\
                    //                     <Verticalized>False</Verticalized>\
                    //                     <StyledText>\
                    //                         <Element>\
                    //                             <String>'+ amount + '</String>\
                    //                             <Attributes>\
                    //                                 <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //                                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                             </Attributes>\
                    //                         </Element>\
                    //                     </StyledText>\
                    //                 </TextObject>\
                    //                 <Bounds X="1700" Y="0" Width="4455" Height="600" />\
                    //             </ObjectInfo>\
                    //             <ObjectInfo>\
                    //                 <TextObject>\
                    //                     <Name>BarcodeText</Name>\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                     <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                     <LinkedObjectName></LinkedObjectName>\
                    //                     <Rotation>Rotation0</Rotation>\
                    //                     <IsMirrored>False</IsMirrored>\
                    //                     <IsVariable>False</IsVariable>\
                    //                     <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                     <VerticalAlignment>Top</VerticalAlignment>\
                    //                     <TextFitMode>AlwaysFit</TextFitMode>\
                    //                     <UseFullFontHeight>False</UseFullFontHeight>\
                    //                     <Verticalized>False</Verticalized>\
                    //                     <StyledText>\
                    //                         <Element>\
                    //                             <String>'+ itemname + '</String>\
                    //                             <Attributes>\
                    //                                 <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //                                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                             </Attributes>\
                    //                         </Element>\
                    //                     </StyledText>\
                    //                 </TextObject>\
                    //                 <Bounds X="332" Y="650" Width="4400" Height="660" />\
                    //             </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <AddressObject>\
                    //                 <Name>ITEM CODE</Name>\
                    //                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                 <LinkedObjectName></LinkedObjectName>\
                    //                 <Rotation>Rotation0</Rotation>\
                    //                 <IsMirrored>False</IsMirrored>\
                    //                 <IsVariable>True</IsVariable>\
                    //                 <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                 <VerticalAlignment>Middle</VerticalAlignment>\
                    //                 <TextFitMode>ShrinkToFit</TextFitMode>\
                    //                 <UseFullFontHeight>True</UseFullFontHeight>\
                    //                 <Verticalized>False</Verticalized>\
                    //                 <StyledText>\
                    //                     <Element>\
                    //                         <String>'+ itemcode + '\n</String>\
                    //                         <Attributes>\
                    //                             <Font Family="Arial" Size="250" Bold="false" Italic="False" Underline="False" Strikeout="False" />\
                    //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                         </Attributes>\
                    //                     </Element>\
                    //                 </StyledText>\
                    //                 <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                    //                 <BarcodePosition>AboveAddress</BarcodePosition>\
                    //                 <LineFonts>\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 </LineFonts>\
                    //             </AddressObject>\
                    //             <Bounds X="4000" Y="950" Width="1455" Height="200" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <BarcodeObject>\
                    //                 <Name>Barcode</Name>\
                    //                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                 <LinkedObjectName>'+ barnumber + '</LinkedObjectName>\
                    //                 <Rotation>Rotation0</Rotation>\
                    //                 <IsMirrored>False</IsMirrored>\
                    //                 <IsVariable>True</IsVariable>\
                    //                 <Text>.</Text>\
                    //                 <Type>Code128Auto</Type>\
                    //                 <Size>Medium</Size>\
                    //                 <TextPosition>Bottom</TextPosition>\
                    //                 <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 <TextEmbedding>None</TextEmbedding>\
                    //                 <ECLevel>0</ECLevel>\
                    //                 <HorizontalAlignment>Center</HorizontalAlignment>\
                    //                 <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                    //             </BarcodeObject>\
                    //             <Bounds X="2600" Y="1000" Width="2550" Height="520" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <AddressObject>\
                    //                 <Name>BAR CODE</Name>\
                    //                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                 <LinkedObjectName></LinkedObjectName>\
                    //                 <Rotation>Rotation0</Rotation>\
                    //                 <IsMirrored>False</IsMirrored>\
                    //                 <IsVariable>True</IsVariable>\
                    //                 <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                 <VerticalAlignment>Middle</VerticalAlignment>\
                    //                 <TextFitMode>ShrinkToFit</TextFitMode>\
                    //                 <UseFullFontHeight>True</UseFullFontHeight>\
                    //                 <Verticalized>False</Verticalized>\
                    //                 <StyledText>\
                    //                     <Element>\
                    //                         <String>'+ barnumber + '</String>\
                    //                         <Attributes>\
                    //                             <Font Family="Arial" Size="250" Bold="false" Italic="False" Underline="False" Strikeout="False" />\
                    //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                         </Attributes>\
                    //                     </Element>\
                    //                 </StyledText>\
                    //                 <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                    //                 <BarcodePosition>AboveAddress</BarcodePosition>\
                    //                 <LineFonts>\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 </LineFonts>\
                    //             </AddressObject>\
                    //             <Bounds X="3500" Y="1400" Width="2455" Height="200" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <AddressObject>\
                    //                 <Name>ITEM DESCRIPTION</Name>\
                    //                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                 <LinkedObjectName></LinkedObjectName>\
                    //                 <Rotation>Rotation0</Rotation>\
                    //                 <IsMirrored>False</IsMirrored>\
                    //                 <IsVariable>True</IsVariable>\
                    //                 <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                 <VerticalAlignment>Middle</VerticalAlignment>\
                    //                 <TextFitMode>ShrinkToFit</TextFitMode>\
                    //                 <UseFullFontHeight>True</UseFullFontHeight>\
                    //                 <Verticalized>False</Verticalized>\
                    //                 <StyledText>\
                    //                     <Element>\
                    //                         <String>' + itemdescript + '</String>\
                    //                         <Attributes>\
                    //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                         </Attributes>\
                    //                     </Element>\
                    //                 </StyledText>\
                    //                 <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                    //                 <BarcodePosition>AboveAddress</BarcodePosition>\
                    //                 <LineFonts>\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 </LineFonts>\
                    //             </AddressObject>\
                    //             <Bounds X="200" Y="850" Width="1455" Height="360" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <AddressObject>\
                    //                 <Name>QUANTITy</Name>\
                    //                 <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //                 <LinkedObjectName></LinkedObjectName>\
                    //                 <Rotation>Rotation0</Rotation>\
                    //                 <IsMirrored>False</IsMirrored>\
                    //                 <IsVariable>True</IsVariable>\
                    //                 <HorizontalAlignment>Left</HorizontalAlignment>\
                    //                 <VerticalAlignment>Middle</VerticalAlignment>\
                    //                 <TextFitMode>ShrinkToFit</TextFitMode>\
                    //                 <UseFullFontHeight>True</UseFullFontHeight>\
                    //                 <Verticalized>False</Verticalized>\
                    //                 <StyledText>\
                    //                     <Element>\
                    //                         <String>' + itemqty + '</String>\
                    //                         <Attributes>\
                    //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                         </Attributes>\
                    //                     </Element>\
                    //                 </StyledText>\
                    //                 <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                    //                 <BarcodePosition>AboveAddress</BarcodePosition>\
                    //                 <LineFonts>\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                 </LineFonts>\
                    //             </AddressObject>\
                    //             <Bounds X="332" Y="1000" Width="2455" Height="660" />\
                    //         </ObjectInfo>\
                    //     </DieCutLabel>';
                    // var testAddressLabelXml = '<?xml version="1.0" encoding="utf-8"?>\
                    // <DieCutLabel Version="8.0" Units="twips">\
                    //       <PaperOrientation>Landscape</PaperOrientation>\
                    //       <Id>Small30336</Id>\
                    //       <PaperName>30336 1 in x 2-1/8 in</PaperName>\
                    //       <DrawCommands>\
                    //         <RoundRectangle X="0" Y="0" Width="3060" Height="1440" Rx="180" Ry="180" />\
                    //       </DrawCommands>\
                    //         <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>AMOUNT</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>$30.00</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="1032" Y="1000" Width="455" Height="1260" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>ITEMNAME</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>DUSSE VSOP COGNAC BTL</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="800" Y="0" Width="455" Height="3000" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>UNIT</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>700ml Bottle</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="632" Y="250" Width="455" Height="1265" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>ITEMCODE</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>20841</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="632" Y="2300" Width="455" Height="660" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>QUANTITY</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>1 PK</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="400" Y="250" Width="455" Height="800" />\
                    //         </ObjectInfo>\
                    //         <ObjectInfo>\
                    //         <BarcodeObject>\
                    //             <Name>Barcode</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName>False</LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <Text>081753835156</Text>\
                    //             <Type>Code128Auto</Type>\
                    //             <Size>Small</Size>\
                    //             <TextPosition>None</TextPosition>\
                    //             <TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //             <CheckSumFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    //             <TextEmbedding>None</TextEmbedding>\
                    //             <ECLevel>0</ECLevel>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                    //         </BarcodeObject>\
                    //         <Bounds X="550" Y="950" Width="200" Height="2300" />\
                    //     </ObjectInfo>\
                    //     <ObjectInfo>\
                    //             <TextObject>\
                    //             <Name>SERIAL</Name>\
                    //             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                    //             <LinkedObjectName></LinkedObjectName>\
                    //             <Rotation>Rotation270</Rotation>\
                    //             <IsMirrored>False</IsMirrored>\
                    //             <IsVariable>True</IsVariable>\
                    //             <HorizontalAlignment>Center</HorizontalAlignment>\
                    //             <VerticalAlignment>Middle</VerticalAlignment>\
                    //             <TextFitMode>None</TextFitMode>\
                    //             <UseFullFontHeight>True</UseFullFontHeight>\
                    //             <Verticalized>False</Verticalized>\
                    //             <StyledText>\
                    //                 <Element>\
                    //                 <String>081753835156</String>\
                    //                 <Attributes>\
                    //                     <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                    //                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                    //                 </Attributes>\
                    //                 </Element>\
                    //             </StyledText>\
                    //             </TextObject>\
                    //             <Bounds X="132" Y="1580" Width="455" Height="1440" />\
                    //         </ObjectInfo>\
                    //     </DieCutLabel>';
                    // 30256 Shipping Sample
            var testAddressLabelXml = '<?xml version="1.0" encoding="utf-8"?>\
            <DieCutLabel Version="8.0" Units="twips">\
                  <PaperOrientation>Portrait</PaperOrientation>\
                  <Id>LargeShipping</Id>\
                  <PaperName>30256 Shipping</PaperName>\
                  <DrawCommands>\
                  <RoundRectangle X="0" Y="0" Width="3036" Height="1400" Rx="270" Ry="270"/>\
                  </DrawCommands>\
                    <ObjectInfo>\
                        <TextObject>\
                        <Name>AMOUNT</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>$30.00</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="1000" Y="0" Width="1055" Height="360" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                        <TextObject>\
                        <Name>ITEMNAME</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>DUSSE VSOP COGNAC BTL</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="300" Y="300" Width="2500" Height="400" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                        <TextObject>\
                        <Name>UNIT</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>700ml Btl</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="200" Y="452" Width="855" Height="400" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                        <TextObject>\
                        <Name>ITEMCODE</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>20841</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="1732" Y="452" Width="1455" Height="400" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                        <TextObject>\
                        <Name>QUANTITY</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>1 PK</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="200" Y="450" Width="455" Height="800" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                    <BarcodeObject>\
                        <Name>Barcode</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName>False</LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <Text>081753835156</Text>\
                        <Type>Code128Auto</Type>\
                        <Size>Small</Size>\
                        <TextPosition>None</TextPosition>\
                        <TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                        <CheckSumFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                        <TextEmbedding>None</TextEmbedding>\
                        <ECLevel>0</ECLevel>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                    </BarcodeObject>\
                    <Bounds X="950" Y="750" Width="2000" Height="200" />\
                </ObjectInfo>\
                <ObjectInfo>\
                        <TextObject>\
                        <Name>SERIAL</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>None</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                            <String>081753835156</String>\
                            <Attributes>\
                                <Font Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            </Attributes>\
                            </Element>\
                        </StyledText>\
                        </TextObject>\
                        <Bounds X="1150" Y="950" Width="2000" Height="200" />\
                    </ObjectInfo>\
                </DieCutLabel>';
                        small_label_xml.push(testAddressLabelXml);
                       
                           
                        }
                        return small_label_xml;
            }

            // document.getElementsByClassName("itemCodeText")[0].value = itemname;
            // document.getElementsByClassName("serialNumberText")[0].value = amount;
            // document.getElementsByClassName("repairCompanyText")[0].value = itemdescript;
            // document.getElementsByClassName("repairCompanyTextProduct")[0].value = itemcode;
            // document.getElementsByClassName("documentNumberText")[0].value = barnumber;

            // console.log(
            //     amount + '\n' + itemname + '\n' + barnumber + '\n' + itemdescript + '\n' + itemcode + '\n' + itemqty
            // );
            // var testAddressLabelXml = '<?xml version="1.0" encoding="utf-8"?>\
            //             <DieCutLabel Version="8.0" Units="twips">\
            //                 <PaperOrientation>Landscape</PaperOrientation>\
            //                 <Id>Address</Id>\
            //                 <PaperName>30252 Address</PaperName>\
            //                 <DrawCommands>\
            //                 <RoundRectangle X="0" Y="0" Width="3000" Height="5040" Rx="270" Ry="270" />\
            //                 </DrawCommands>\
            //                 <ObjectInfo>\
            //                         <TextObject>\
            //                             <Name>BarcodeText</Name>\
            //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                             <LinkedObjectName></LinkedObjectName>\
            //                             <Rotation>Rotation0</Rotation>\
            //                             <IsMirrored>False</IsMirrored>\
            //                             <IsVariable>False</IsVariable>\
            //                             <HorizontalAlignment>Left</HorizontalAlignment>\
            //                             <VerticalAlignment>Top</VerticalAlignment>\
            //                             <TextFitMode>AlwaysFit</TextFitMode>\
            //                             <UseFullFontHeight>False</UseFullFontHeight>\
            //                             <Verticalized>False</Verticalized>\
            //                             <StyledText>\
            //                                 <Element>\
            //                                     <String>'+ amount + '</String>\
            //                                     <Attributes>\
            //                                         <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
            //                                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                     </Attributes>\
            //                                 </Element>\
            //                             </StyledText>\
            //                         </TextObject>\
            //                         <Bounds X="1700" Y="0" Width="4455" Height="600" />\
            //                     </ObjectInfo>\
            //                     <ObjectInfo>\
            //                         <TextObject>\
            //                             <Name>BarcodeText</Name>\
            //                             <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                             <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                             <LinkedObjectName></LinkedObjectName>\
            //                             <Rotation>Rotation0</Rotation>\
            //                             <IsMirrored>False</IsMirrored>\
            //                             <IsVariable>False</IsVariable>\
            //                             <HorizontalAlignment>Left</HorizontalAlignment>\
            //                             <VerticalAlignment>Top</VerticalAlignment>\
            //                             <TextFitMode>AlwaysFit</TextFitMode>\
            //                             <UseFullFontHeight>False</UseFullFontHeight>\
            //                             <Verticalized>False</Verticalized>\
            //                             <StyledText>\
            //                                 <Element>\
            //                                     <String>'+ itemname + '</String>\
            //                                     <Attributes>\
            //                                         <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
            //                                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                     </Attributes>\
            //                                 </Element>\
            //                             </StyledText>\
            //                         </TextObject>\
            //                         <Bounds X="332" Y="650" Width="4400" Height="660" />\
            //                     </ObjectInfo>\
            //                 <ObjectInfo>\
            //                     <AddressObject>\
            //                         <Name>ITEM CODE</Name>\
            //                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                         <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                         <LinkedObjectName></LinkedObjectName>\
            //                         <Rotation>Rotation0</Rotation>\
            //                         <IsMirrored>False</IsMirrored>\
            //                         <IsVariable>True</IsVariable>\
            //                         <HorizontalAlignment>Left</HorizontalAlignment>\
            //                         <VerticalAlignment>Middle</VerticalAlignment>\
            //                         <TextFitMode>ShrinkToFit</TextFitMode>\
            //                         <UseFullFontHeight>True</UseFullFontHeight>\
            //                         <Verticalized>False</Verticalized>\
            //                         <StyledText>\
            //                             <Element>\
            //                                 <String>'+ itemcode + '\n</String>\
            //                                 <Attributes>\
            //                                     <Font Family="Arial" Size="250" Bold="false" Italic="False" Underline="False" Strikeout="False" />\
            //                                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                 </Attributes>\
            //                             </Element>\
            //                         </StyledText>\
            //                         <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
            //                         <BarcodePosition>AboveAddress</BarcodePosition>\
            //                         <LineFonts>\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         </LineFonts>\
            //                     </AddressObject>\
            //                     <Bounds X="4000" Y="950" Width="1455" Height="200" />\
            //                 </ObjectInfo>\
            //                 <ObjectInfo>\
            //                     <BarcodeObject>\
            //                         <Name>Barcode</Name>\
            //                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                         <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                         <LinkedObjectName>'+ barnumber + '</LinkedObjectName>\
            //                         <Rotation>Rotation0</Rotation>\
            //                         <IsMirrored>False</IsMirrored>\
            //                         <IsVariable>True</IsVariable>\
            //                         <Text>.</Text>\
            //                         <Type>Code128Auto</Type>\
            //                         <Size>Medium</Size>\
            //                         <TextPosition>Bottom</TextPosition>\
            //                         <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         <TextEmbedding>None</TextEmbedding>\
            //                         <ECLevel>0</ECLevel>\
            //                         <HorizontalAlignment>Center</HorizontalAlignment>\
            //                         <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
            //                     </BarcodeObject>\
            //                     <Bounds X="2600" Y="1000" Width="2550" Height="520" />\
            //                 </ObjectInfo>\
            //                 <ObjectInfo>\
            //                     <AddressObject>\
            //                         <Name>BAR CODE</Name>\
            //                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                         <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                         <LinkedObjectName></LinkedObjectName>\
            //                         <Rotation>Rotation0</Rotation>\
            //                         <IsMirrored>False</IsMirrored>\
            //                         <IsVariable>True</IsVariable>\
            //                         <HorizontalAlignment>Left</HorizontalAlignment>\
            //                         <VerticalAlignment>Middle</VerticalAlignment>\
            //                         <TextFitMode>ShrinkToFit</TextFitMode>\
            //                         <UseFullFontHeight>True</UseFullFontHeight>\
            //                         <Verticalized>False</Verticalized>\
            //                         <StyledText>\
            //                             <Element>\
            //                                 <String>'+ barnumber + '</String>\
            //                                 <Attributes>\
            //                                     <Font Family="Arial" Size="250" Bold="false" Italic="False" Underline="False" Strikeout="False" />\
            //                                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                 </Attributes>\
            //                             </Element>\
            //                         </StyledText>\
            //                         <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
            //                         <BarcodePosition>AboveAddress</BarcodePosition>\
            //                         <LineFonts>\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         </LineFonts>\
            //                     </AddressObject>\
            //                     <Bounds X="3500" Y="1400" Width="2455" Height="200" />\
            //                 </ObjectInfo>\
            //                 <ObjectInfo>\
            //                     <AddressObject>\
            //                         <Name>ITEM DESCRIPTION</Name>\
            //                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                         <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                         <LinkedObjectName></LinkedObjectName>\
            //                         <Rotation>Rotation0</Rotation>\
            //                         <IsMirrored>False</IsMirrored>\
            //                         <IsVariable>True</IsVariable>\
            //                         <HorizontalAlignment>Left</HorizontalAlignment>\
            //                         <VerticalAlignment>Middle</VerticalAlignment>\
            //                         <TextFitMode>ShrinkToFit</TextFitMode>\
            //                         <UseFullFontHeight>True</UseFullFontHeight>\
            //                         <Verticalized>False</Verticalized>\
            //                         <StyledText>\
            //                             <Element>\
            //                                 <String>' + itemdescript + '</String>\
            //                                 <Attributes>\
            //                                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                 </Attributes>\
            //                             </Element>\
            //                         </StyledText>\
            //                         <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
            //                         <BarcodePosition>AboveAddress</BarcodePosition>\
            //                         <LineFonts>\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         </LineFonts>\
            //                     </AddressObject>\
            //                     <Bounds X="200" Y="850" Width="1455" Height="360" />\
            //                 </ObjectInfo>\
            //                 <ObjectInfo>\
            //                     <AddressObject>\
            //                         <Name>QUANTITy</Name>\
            //                         <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                         <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
            //                         <LinkedObjectName></LinkedObjectName>\
            //                         <Rotation>Rotation0</Rotation>\
            //                         <IsMirrored>False</IsMirrored>\
            //                         <IsVariable>True</IsVariable>\
            //                         <HorizontalAlignment>Left</HorizontalAlignment>\
            //                         <VerticalAlignment>Middle</VerticalAlignment>\
            //                         <TextFitMode>ShrinkToFit</TextFitMode>\
            //                         <UseFullFontHeight>True</UseFullFontHeight>\
            //                         <Verticalized>False</Verticalized>\
            //                         <StyledText>\
            //                             <Element>\
            //                                 <String>' + itemqty + '</String>\
            //                                 <Attributes>\
            //                                     <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                                     <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
            //                                 </Attributes>\
            //                             </Element>\
            //                         </StyledText>\
            //                         <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
            //                         <BarcodePosition>AboveAddress</BarcodePosition>\
            //                         <LineFonts>\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                             <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
            //                         </LineFonts>\
            //                     </AddressObject>\
            //                     <Bounds X="332" Y="1000" Width="2455" Height="660" />\
            //                 </ObjectInfo>\
            //             </DieCutLabel>';

            //return testAddressLabelXml;
        }
        function getAddressLabelXml_club_sale() {
            var title = "MEMBERS'";
            var tit_dwn = 'CLUB SALE PRICE';
           // var PARA_ONE = document.getElementById('cs_pname').innerText;
           // var PARA_SECOND = 'COGNAC CASK !# YEAR';
           
            // var barnumber = document.getElementById('cs_pbarcode').innerText;
            // var itemdescript = document.getElementById('cs_psizeunit').innerText;
            // var itemcode = document.getElementById('cs_pskuNo').innerText;
            // var RP = document.getElementById('cs_prp').innerText;
            // var CP = document.getElementById('cs_pcp').innerText;
            // var CSP = document.getElementById('cs_pcsp').innerText;
            // var UNIT = document.getElementById('cs_punit').innerText;
            // var SAVE = document.getElementById('cs_psave').innerText;

            var id = document.getElementsByClassName("srlno_club_sale");
            let clubsale_label_xml = [];
            console.log(id.length);
                     if (id.length > 0) {
                
             
                       for (let i = 0; i < id.length; i++) 
                       {
                            var PARA_ONE1 = document.getElementById('cs_pname'+id[i].value).innerText; 
                            var PARA_ONE=first(PARA_ONE1);
                            var PARA_SECOND =second(PARA_ONE1);
                            var PARA ='';
                            // if(PARA_ONE.length > 30)
                            // {
                            //    // PARA_ONE='TEST';
                            //    var temp = PARA_ONE.length < 30 ? PARA_ONE.length : 30; 
                            //    console.log(temp);
                            //    PARA_SECOND = truncateString(PARA_ONE,31,temp);
                            // }
                            // PARA_ONE = truncateString(PARA_ONE,0,30);
                            
                            if(PARA_ONE1.length > 25)
                            {
                                console.log("TTTTTTTTT");
                                if(PARA_SECOND.length > 15)
                                {
                                    var Size ='<Bounds X="350" Y="1550" Width="2265" Height="160" />';
                                }
                                else{
                                    var Size ='<Bounds X="350" Y="1550" Width="2265" Height="130" />';
                                }
                                var PARA ='<ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_ONE + '</String>\
                                            <Attributes>\
                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                <Bounds X="350" Y="1370" Width="2265" Height="160" />\
                            </ObjectInfo>\
                            <ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA_SEC</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_SECOND + '</String>\
                                            <Attributes>\
                                                <Font Family="Arial" Size="10" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                '+Size+'\
                            </ObjectInfo>';
                               
                            }
                            if(PARA_ONE1.length <= 25)
                            {
                                console.log("DSMALL STRING");
                                var PARA = '<ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_ONE + '</String>\
                                            <Attributes>\
                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                <Bounds X="350" Y="1450" Width="2265" Height="320" />\
                            </ObjectInfo>';
                               
                            }

                            var barnumber = document.getElementById('cs_pbarcode'+id[i].value).innerText;
                            var itemdescript = document.getElementById('cs_psizeunit'+id[i].value).innerText;
                            var itemcode = document.getElementById('cs_pskuNo'+id[i].value).innerText;
                            var RP = document.getElementById('cs_prp'+id[i].value).innerText;
                            var CP = document.getElementById('cs_pcp'+id[i].value).innerText;
                            var CSP = document.getElementById('cs_pcsp'+id[i].value).innerText;
                            var UNIT = document.getElementById('cs_punit'+id[i].value).innerText;
                            var SAVE = document.getElementById('cs_psave'+id[i].value).innerText;

                            

                            var testAddressLabelXml_CLUB_SALE = '<?xml version="1.0" encoding="utf-8"?>\
                            <DieCutLabel Version="8.0" Units="twips">\
                            <PaperOrientation>Portrait</PaperOrientation>\
                            <Id>LargeShipping</Id>\
                            <PaperName>30256 Shipping</PaperName>\
                                <DrawCommands>\
                                    <RoundRectangle X="0" Y="0" Width="2881" Height="5040" Rx="270" Ry="270" />\
                                </DrawCommands>\
                                <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ title + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Impact" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="925" Y="800" Width="1265" Height="325" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE_BELOW</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ tit_dwn + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Impact" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="600" Y="1090" Width="1865" Height="325" />\
                                            </ObjectInfo>\
                                            '+PARA+'\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE_PARA_LINE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>____________________</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="120" Y="1750" Width="2705" Height="245" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>ITEM_CODE_DESCR</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ itemcode + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="130" Y="1850" Width="2489" Height="160" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>ITEM_CODE_DESC</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Right</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ itemdescript + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="300" Y="1850" Width="2489" Height="160" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>RETAIL_PRICE_AMT</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255"/>\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>False</IsVariable>\
                                                <HorizontalAlignment>Right</HorizontalAlignment>\
                                                <VerticalAlignment>Middle</VerticalAlignment>\
                                                <TextFitMode>AlwaysFit</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>'+ RP + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="True" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds  X="300" Y="2150" Width="2500.8" Height="350"/>\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>CLUB_PRICE_AMT</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255"/>\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>False</IsVariable>\
                                                <HorizontalAlignment>Right</HorizontalAlignment>\
                                                <VerticalAlignment>Middle</VerticalAlignment>\
                                                <TextFitMode>AlwaysFit</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>'+ CP + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial Bold" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="True" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds  X="300" Y="2580" Width="2500.8" Height="350"/>\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>TEXT_RETAIL_PRICE</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                                <VerticalAlignment>Top</VerticalAlignment>\
                                                <TextFitMode>None</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>RETAIL ($)'+ '\n' + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                <Element>\
                                                <String>PRICE</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds X="150" Y="2150"  Width="5775" Height="13800" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>TEXT_CLUB_PRICE</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                                <VerticalAlignment>Top</VerticalAlignment>\
                                                <TextFitMode>None</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>CLUB ($)'+ '\n' + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                <Element>\
                                                <String>PRICE</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds X="150" Y="2580"  Width="5775" Height="13800" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>TEXT_CLUB_SALE_PRICE</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                                <VerticalAlignment>Top</VerticalAlignment>\
                                                <TextFitMode>None</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>CLUB ($)'+ '\n' + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                <Element>\
                                                <String>SALE PRICE</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds X="150" Y="3050"  Width="5775" Height="13800" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>CLUB_PRICE_AMT</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255"/>\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>False</IsVariable>\
                                                <HorizontalAlignment>Right</HorizontalAlignment>\
                                                <VerticalAlignment>Middle</VerticalAlignment>\
                                                <TextFitMode>AlwaysFit</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>'+ CSP + '</String>\
                                                <Attributes>\
                                                    <Font Family="Impact" Size="35" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds  X="300" Y="2950" Width="2500.8" Height="550"/>\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PARA_LINE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>____________________</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="120" Y="3500" Width="2705" Height="245" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>UNIT ($)</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="-200" Y="3550" Width="2089" Height="250" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>SAVE ($)</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="1100" Y="3550" Width="2089" Height="250" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE</Name>\
                                                    <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                    <BackColor Alpha="255" Red="9" Green="0" Blue="0" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ UNIT +'</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="250" Y="3850" Width="1000" Height="300" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE_SAVE</Name>\
                                                    <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                    <BackColor Alpha="255" Red="9" Green="0" Blue="0" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ SAVE +'</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="1500" Y="3850" Width="1089" Height="300" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                            <BarcodeObject>\
                                                <Name>Barcode</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName>'+ barnumber + '</LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <Text>'+ barnumber + '</Text>\
                                                <Type>Code128Auto</Type>\
                                                <Size>Small</Size>\
                                                <TextPosition>Bottom</TextPosition>\
                                                <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <TextEmbedding>None</TextEmbedding>\
                                                <ECLevel>0</ECLevel>\
                                                <HorizontalAlignment>Center</HorizontalAlignment>\
                                                <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                                            </BarcodeObject>\
                                            <Bounds X="110" Y="4200" Width="2581" Height="520" />\
                                        </ObjectInfo>\
                            </DieCutLabel>';
                        
                            clubsale_label_xml.push(testAddressLabelXml_CLUB_SALE);
                       }
                       return clubsale_label_xml;
                    }



           
            //return  test4;
        }
        
        function getAddressLabelXml_club() {
            var title = "MEMBERS'";
            var tit_dwn = 'CLUB PRICE';
           // var PARA_ONE = document.getElementById('c_pname').innerText;
            ///var PARA_SECOND = 'COGNAC CASK';
           
            // var barnumber = document.getElementById('c_pbarcode').innerText;
            // var itemdescript = document.getElementById('c_psizeunit').innerText;
            // var itemcode = document.getElementById('c_pskuNo').innerText;
            // var RP =  document.getElementById('c_prp').innerText;
            // var CP = document.getElementById('c_pcp').innerText;
           
            // var UNIT =  document.getElementById('c_punit').innerText;
            // var SAVE = document.getElementById('c_psave').innerText;

            var id = document.getElementsByClassName("srlno_club");
            let club_label_xml = [];
            console.log(id.length);
            if (id.length > 0) {
                
             
                       for (let i = 0; i < id.length; i++) 
                       {
                            //alert(id[i].value);
                            console.log(id[i].value,i);
                            var PARA_ONE1 = document.getElementById('c_pname'+id[i].value).innerText;
                            var PARA_ONE=first(PARA_ONE1);
                            var PARA_SECOND =second(PARA_ONE1);
                            console.log("LENGHT");
                            console.log(PARA_ONE1.length);
                           
                            
                            // if(PARA_ONE.length > 30)
                            // {
                               
                            //    var temp = PARA_ONE.length < 30 ? PARA_ONE.length : 30; 
                            //    PARA_SECOND = truncateString(PARA_ONE,31,temp);
                               
                            // }
                            // PARA_ONE = truncateString(PARA_ONE,0,30);
                           
                            
                            if(PARA_ONE1.length > 25)
                            {
                                console.log("TTTTTTTTT");
                                
                                if(PARA_SECOND.length > 15)
                                {
                                    var Size = '<Bounds X="350" Y="1540" Width="2265" Height="160" />';

                                }else{
                                    var Size = '<Bounds X="350" Y="1540" Width="2265" Height="130" />';
                                }
                                var PARA ='<ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_ONE + '</String>\
                                            <Attributes>\
                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                <Bounds X="350" Y="1380" Width="2265" Height="160" />\
                            </ObjectInfo>\
                            <ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA_SEC</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_SECOND + '</String>\
                                             <Attributes>\
                                                <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                '+Size+'\
                            </ObjectInfo>';
                               
                            }
                            if(PARA_ONE1.length <= 25)
                            {
                                console.log("DSMALL STRING");
                                var PARA = '<ObjectInfo>\
                                <TextObject>\
                                    <Name>TITLE_PARA</Name>\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                    <LinkedObjectName></LinkedObjectName>\
                                    <Rotation>Rotation0</Rotation>\
                                    <IsMirrored>False</IsMirrored>\
                                    <IsVariable>False</IsVariable>\
                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                    <VerticalAlignment>Top</VerticalAlignment>\
                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                    <Verticalized>False</Verticalized>\
                                    <StyledText>\
                                        <Element>\
                                            <String>'+ PARA_ONE + '</String>\
                                            <Attributes>\
                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                            </Attributes>\
                                        </Element>\
                                    </StyledText>\
                                </TextObject>\
                                <Bounds X="350" Y="1440" Width="2265" Height="320" />\
                            </ObjectInfo>';
                               
                            }
                            var barnumber = document.getElementById('c_pbarcode'+id[i].value).innerText;
                            var itemdescript = document.getElementById('c_psizeunit'+id[i].value).innerText;
                            var itemcode = document.getElementById('c_pskuNo'+id[i].value).innerText;
                            var RP =  document.getElementById('c_prp'+id[i].value).innerText;
                            var CP = document.getElementById('c_pcp'+id[i].value).innerText;
                        
                            var UNIT =  document.getElementById('c_punit'+id[i].value).innerText;
                            var SAVE = document.getElementById('c_psave'+id[i].value).innerText;
                            //alert(PARA_ONE);

                            console.log(PARA_ONE,itemcode,CP);

                            var testAddressLabelXml_CLUB = '<?xml version="1.0" encoding="utf-8"?>\
                            <DieCutLabel Version="8.0" Units="twips">\
                            <PaperOrientation>Portrait</PaperOrientation>\
                            <Id>LargeShipping</Id>\
                            <PaperName>30256 Shipping</PaperName>\
                                <DrawCommands>\
                                    <RoundRectangle X="0" Y="0" Width="2881" Height="5040" Rx="270" Ry="270" />\
                                </DrawCommands>\
                                <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ title + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Impact" Size="24" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="850" Y="800" Width="1265" Height="345" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE_BELOW</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ tit_dwn + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Impact" Size="24" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="780" Y="1080" Width="1365" Height="345" />\
                                            </ObjectInfo>\
                                            '+PARA+'\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>TITLE_PARA_LINE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>_____________________________</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="100" Y="1700" Width="2680" Height="245" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>ITEM_CODE_DESCR</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ itemcode + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="130" Y="1900" Width="2489" Height="160" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>ITEM_CODE_DESC</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Right</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ itemdescript + '</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="295" Y="1900" Width="2489" Height="160" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>RETAIL_PRICE_AMT</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255"/>\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>False</IsVariable>\
                                                <HorizontalAlignment>Right</HorizontalAlignment>\
                                                <VerticalAlignment>Middle</VerticalAlignment>\
                                                <TextFitMode>AlwaysFit</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>'+ RP + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="10" Bold="True" Italic="False" Underline="False" Strikeout="True" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds  X="280" Y="2200" Width="2500.8" Height="350"/>\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>CLUB_PRICE_AMT</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0"/>\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255"/>\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>False</IsVariable>\
                                                <HorizontalAlignment>Right</HorizontalAlignment>\
                                                <VerticalAlignment>Middle</VerticalAlignment>\
                                                <TextFitMode>AlwaysFit</TextFitMode>\
                                                <UseFullFontHeight>False</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>'+ CP + '</String>\
                                                <Attributes>\
                    <Font Family="Impact" Size="35" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds  X="220" Y="2800" Width="2600.8" Height="450"/>\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>TEXT_RETAIL_PRICE</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                                <VerticalAlignment>Top</VerticalAlignment>\
                                                <TextFitMode>None</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>RETAIL ($)'+ '\n' + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                <Element>\
                                                <String>PRICE</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds X="160" Y="2250"  Width="5775" Height="13800" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                <Name>TEXT_CLUB_PRICE</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName></LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                                <VerticalAlignment>Top</VerticalAlignment>\
                                                <TextFitMode>None</TextFitMode>\
                                                <UseFullFontHeight>True</UseFullFontHeight>\
                                                <Verticalized>False</Verticalized>\
                                                <StyledText>\
                                                <Element>\
                                                <String>CLUB ($)'+ '\n' + '</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                <Element>\
                                                <String>PRICE</String>\
                                                <Attributes>\
                                                    <Font Family="Arial" Size="8" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                </Attributes>\
                                                </Element>\
                                                </StyledText>\
                                                </TextObject>\
                                                <Bounds X="160" Y="2900"  Width="5775" Height="13800" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PARA_LINE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Left</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>____________________</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="15" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="90" Y="3400" Width="2685" Height="245" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>UNIT($)</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="-250" Y="3500" Width="2089" Height="250" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE2</Name>\
                                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                    <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>SAVE($)</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="1100" Y="3500" Width="2089" Height="250" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE</Name>\
                                                    <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                    <BackColor Alpha="255" Red="9" Green="0" Blue="0" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ UNIT +'</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="250" Y="3800" Width="1089" Height="300" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                                <TextObject>\
                                                    <Name>BOTTOM_PRICE_SAVE</Name>\
                                                    <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                    <BackColor Alpha="255" Red="9" Green="0" Blue="0" />\
                                                    <LinkedObjectName></LinkedObjectName>\
                                                    <Rotation>Rotation0</Rotation>\
                                                    <IsMirrored>False</IsMirrored>\
                                                    <IsVariable>False</IsVariable>\
                                                    <HorizontalAlignment>Center</HorizontalAlignment>\
                                                    <VerticalAlignment>Top</VerticalAlignment>\
                                                    <TextFitMode>AlwaysFit</TextFitMode>\
                                                    <UseFullFontHeight>False</UseFullFontHeight>\
                                                    <Verticalized>False</Verticalized>\
                                                    <StyledText>\
                                                        <Element>\
                                                            <String>'+ SAVE +'</String>\
                                                            <Attributes>\
                                                                <Font Family="Arial" Size="5" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                                <ForeColor Alpha="255" Red="255" Green="255" Blue="255" />\
                                                            </Attributes>\
                                                        </Element>\
                                                    </StyledText>\
                                                </TextObject>\
                                                <Bounds X="1600" Y="3800" Width="1089" Height="300" />\
                                            </ObjectInfo>\
                                            <ObjectInfo>\
                                            <BarcodeObject>\
                                                <Name>Barcode</Name>\
                                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                                <LinkedObjectName>'+ barnumber + '</LinkedObjectName>\
                                                <Rotation>Rotation0</Rotation>\
                                                <IsMirrored>False</IsMirrored>\
                                                <IsVariable>True</IsVariable>\
                                                <Text>'+ barnumber + '</Text>\
                                                <Type>Code128Auto</Type>\
                                                <Size>Small</Size>\
                                                <TextPosition>Bottom</TextPosition>\
                                                <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                                <TextEmbedding>None</TextEmbedding>\
                                                <ECLevel>0</ECLevel>\
                                                <HorizontalAlignment>Center</HorizontalAlignment>\
                                                <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                                            </BarcodeObject>\
                                            <Bounds X="100" Y="4250" Width="2550" Height="450" />\
                                        </ObjectInfo>\
                            </DieCutLabel>';
                        club_label_xml.push(testAddressLabelXml_CLUB);
                                   
                       }
                       return club_label_xml;
                    }


           
        }
        function loadLabelFromWeb() {
            // use jQuery API to load label
            //$.get("Address.label", function(labelXml)
            //{

            // label = dymo.label.framework.openLabelXml(getAddressLabelXml());
            if (document.getElementById('labelFormatSmall').checked) {
                //label = dymo.label.framework.openLabelXml(getAddressLabelXml());
                var small = getAddressLabelXml();
                for(i=0;i<small.length;i++){
                    label = dymo.label.framework.openLabelXml(small[i]);
                    labels.push(label);
                    console.log(labels);
                    updatePreview();
                }

            } else if (document.getElementById('labelFormatClub').checked) {
                var club = getAddressLabelXml_club();
                for(i=0;i<club.length;i++){
                    label = dymo.label.framework.openLabelXml(club[i]);
                    labels.push(label);
                    console.log(labels);
                    updatePreview();
                }
                
            } else if (document.getElementById('labelFormatClubSale').checked) {
                var club_sale = getAddressLabelXml_club_sale();

               for(i=0;i<club_sale.length;i++){
                    label = dymo.label.framework.openLabelXml(club_sale[i]);
                    labels.push(label);
                    console.log(labels);
                    updatePreview();
                }
            }
            // check that label has an address object

            
            addressTextArea.value = getAddress();
            printButton.disabled = false;
            addressTextArea.disabled = false;
            //}, "text");
        }
        //display();
        // loadLabelFromWeb();


        // load printers list on startup
        // loadPrinters();
    };

    function initTests() {
        if (dymo.label.framework.init) {
            //dymo.label.framework.trace = true;
            dymo.label.framework.init(onload);
        } else {
            onload();
        }
    }

    // register onload event
    if (window.addEventListener)
        window.addEventListener("load", initTests, false);
    else if (window.attachEvent)
        window.attachEvent("onload", initTests);
    else
        window.onload = initTests;

}());