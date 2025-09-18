//functions for content page on website

function DirInto(dir){
    if(dir == ".." || dir == "."){
        return
    }
    var formData = {
            'change' : dir
        };
    $.ajax({
        url: "includes/content.php",
        type: "POST",
        data: formData,
        success: function(result){$("#DynamicContent").html(result);},
        error: function(result){$("#DynamicContent").html("Error!");}
    });
}
/*
function showFile(something){
    var temp = document.getElementsByClassName("temp");
    temp[0].setAttribute("display","block");
}
*/
function fileGrab(something,type){
    if(type == 'download'){
        $.ajax({
            url: "includes/grabber.php",
            type: "POST",
            success: function(result){
                window.location = "includes/grabber.php?type=".concat(type).concat("&file=").concat(something);
                    
            },
            error: function(result){$("#output").html("Error!");}
        });
    }
    if(type == 'delete'){
        const uri = "includes/grabber.php?type=".concat(type).concat("&file=").concat(encodeURIComponent(something));
        $.ajax({
            url: uri,
            type: "POST",
            success: function(result){
                $("#output").html(result);
                var item = document.getElementById(something);
                item.remove();
                    
            },
            error: function(result){$("#output").html("Error!");}
        });
    }
}
function folderDelete(something,type){
    const uri = "includes/grabber.php?type=delete&folder=".concat(encodeURIComponent(something));
    $.ajax({
        url: uri,
        type: "POST",
        success: function(result){
            $("#output").html(result);
            var item = document.getElementById(something);
            item.remove();
                
        },
        error: function(result){$("#output").html("Error!");}
    });
}

//Packages all uploads together and creates progress bars
function uploadFileProgressHandler(){
    document.getElementById("output1").innerHTML = "Once all files are done uploading, reload the directory for them to appear";

    for(let i = 0; i < $('#uploadFile')[0].files.length; i++){
        uploadFile(i,$('#uploadFile')[0].files[i]);
        addProgress($('#uploadFile')[0].files[i].name,i)
    }
}


function uploadFile(index){
    var formData = new FormData();
    formData.append('uploadFile', $('#uploadFile')[0].files[index]);
    const size = $('#uploadFile')[0].files[index].size;
    //const name = [];
    //name[name.length] = $('#uploadFile')[0].files[index].name;
    formData.append("submit",true);
    
    //handle if bigger than 100mb
    if(size > 100000000){
        console.log(true);
    }

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
        
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                percentComplete = parseInt(percentComplete * 100);
                $('#bar2'+index).css("width",percentComplete+"%");
                $('#percent'+index).html(percentComplete+"%");
                if (percentComplete === 100) {
                  $("#status"+index).html("Moving Files...");
                }
        
                }
            }, false);
    
            
            return xhr;
        },
        url: "includes/uploadFile.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        beforeSend: function(){$('#status').html("Uploading file(s)...");},
        success: function(result){
            $("#status"+index).html("<br>"+$("#status"+index).html()+result);
            
        },
        error: function(result){$("#status"+index).html(result);}
    });
}

function makeFolder(){
    var formData = new FormData();
    formData.append('loc', $('#loc').val());
    formData.append('change', "move");
    $.ajax({
        url: "includes/content.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        success: function(result){
            $("#DynamicContent").html(result);
        },
        error: function(result){$("#DynamicContent").html("Error!");}
    });
}

function uploadMenu(){
    var display = document.getElementById("uploadbox").style.display;
    if(display == "block"){
        display = "none"
    }
    else{
        display = "block";
    }
    document.getElementById("uploadbox").style.display = display;
}

function shareMenu(){
    var display = document.getElementById("sharebox").style.display;
    if(display == "block"){
        display = "none"
    }
    else{
        display = "block";
    }
    document.getElementById("sharebox").style.display = display;
}


function addProgress(name,index){
    let progress = document.createElement("div");
    progress.className = "progress"+index;

    let tname = document.createElement("p");
    tname.innerText = name;

    let bar = document.createElement("div");
    bar.className = "bar";

    let bar2 = document.createElement("div");
    bar2.className ="bar2";
    bar2.id = "bar2"+index;
    bar2.style.width = "0%";

    let percent = document.createElement("div");
    percent.id = "percent" + index;
    percent.innerText = "0%";

    let status = document.createElement("div");
    status.id = "status" + index;  

    bar.appendChild(bar2);
    progress.appendChild(tname);
    progress.appendChild(bar);
    progress.appendChild(percent);
    progress.appendChild(status);

    document.getElementById("output1").appendChild(progress);
    //console.log("adding progress"+index)

}


//Sanitize input on php side
function shareCreate() {
    var formData = new FormData();
    formData.append('shareInput', $('#shareInput').val());
    $.ajax({
        url: "includes/shareCreate.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        success: function(result){
            $("#shareOutput").html("<br>"+result);
            },
        error: function(result){$("#shareOutput").html("Error!");}
    });
}

function shareUpdate(){
    var formData = new FormData();
    formData.append('invite', $('#shareUpdateInput').val());
    $.ajax({
        url: "includes/shareUpdate.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        success: function(result){
            $("#shareUpdateOutput").html("<br>"+result);
            },
        error: function(result){$("#shareUpdateOutput").html("Error!");}
    });
}

function serverQuery(target, change){
    var formData = new FormData();
    formData.append('target',target);
    formData.append('change', change);
    $.ajax({
        url: "includes/servers.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType:false,
        success: function(result){
            $("#serverOutput").html(result);
        },
        error: function(result){$("#serverOutput").html("Error!");}
    });
}
