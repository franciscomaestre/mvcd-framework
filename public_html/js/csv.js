/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function table2CSV(tableID,csvName) {
                var str = document.getElementById(tableID).innerHTML;
                str = str.replace(/<!--(.)*-->/g, "");
                str = str.replace(/\n/g, "");
                str = str.replace(/[\t ]+\</g, "<");
                str = str.replace(/\>[\t ]+\</g, "><");
                str = str.replace(/\>[\t ]+$/g, ">");
                str = str.replace(/(\r\n|\n|\r)/gm,'');
                str = str.replace( /<(\/)*(table|tbody)>/gi,'');
                str = str.replace( /<(tr|th|td)>/gi,'');
                str = str.replace( /<\/tr>/gi,'\n');
                str = str.replace( /<\/(td|th)>/gi,';');
                str = str.replace( /(€|%)/gi,'');
                str = str.replace(/&[a-z]{2,6};/gi,' ');
                str = str.replace(/<(.)*>/g, "");
                var uri = 'data:application/csv;charset=utf-8,' + encodeURIComponent(str);
                var downloadLink = document.createElement("a");
                downloadLink.href = uri;
                downloadLink.download = csvName+".csv";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);	
}

function list2CSV(listID,csvName) {
                var str = document.getElementById(listID).innerHTML;
                str = str.replace(/<!--(.)*-->/g, "");
                str = str.replace(/\n/g, "");
                str = str.replace(/[\t ]+\</g, "<");
                str = str.replace(/\>[\t ]+\</g, "><");
                str = str.replace(/\>[\t ]+$/g, ">");
                str = str.replace(/(\r\n|\n|\r)/gm,'');
                str = str.replace( /<(\/)*(table|tbody)>/gi,'');
                str = str.replace( /<\/li>/gi,'\n');
                str = str.replace( /<\/(p|span)>/gi,';');
                str = str.replace( /(€|%)/gi,'');
                str = str.replace(/&[a-z]{2,6};/gi,' ');
                str = str.replace( /<(li|p)>/gi,'');
                str = str.replace( /<span[ a-zA-z0-9\"\'=_-]*>/gi,'');
                str = str.replace(/<(.)*>/g, "");
                str = str.replace(/(<!--|-->)/g, "");
                var uri = 'data:application/csv;charset=utf-8,' + encodeURIComponent(str);
                var downloadLink = document.createElement("a");
                downloadLink.href = uri;
                downloadLink.download = csvName+".csv";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);	
}