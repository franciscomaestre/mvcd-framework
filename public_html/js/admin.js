/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function changeShop(shopId) {
        $.post("/shops/change", 
                { 'shopId':shopId }, 
                
        function(response){

                response = JSON.parse(response);

                console.log(response);

                if(response.result) {
                        location.reload();
                }else {
                        alert("An error occurred");
                }
            });
}