import './bootstrap';
import '../css/app.css';
import '../sass/app.scss';
import * as bootstrap from 'bootstrap';

$(document).ready(function(){
    $(document).on('click', '#send_message',function(e){
        e.preventDefault();
        let username=$('#username').val();
        let message=$('#message').val();

        if(username==''|| message==''){
            alert('Please enter both username and message');
            return false;
        }
        $.ajax({
            method:'POST',
            url:'send-message',
            data:{
                _token:$('meta[name="csrf-token"]').attr('content'),
                username:username,
                message:message
            },
            success:function(data){
                console.log(data);
            },
            error:function(data,textStatus,errorThrown){
                console.log(data);
            }
        });
    });
});
// var user = '';
window.Echo.channel('chat')
        .listen('.message',(e)=>{
            // $('#messageShow').append('<p class="small mb-0">'+e.username+' : '+e.message+'</p>');
            // if(user == e.username){
            $('#messageShow').append('<div class="d-flex flex-row justify-content-start mb-4">'+
            '<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"'+
              'alt="avatar 1" style="width: 45px; height: 100%;">'+
            '<div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">'+
            '<p class="small mb-0">'+e.username+' : '+e.message+'</p></div></div>');
            // user = e.username;
            // }else{
            //     $('#messageShow').append('<div class="d-flex flex-row justify-content-start mb-4">'+
            // '<div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">'+
            // '<p class="small mb-0">'+e.username+' : '+e.message+'</p></div>'+
            // '<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"'+
            //   'alt="avatar 1" style="width: 45px; height: 100%;"></div>');
            // }
            $('#message').val(' ');
        });