<div id="uploadbox">
    <button id="uploadbutton" style="float:right" onclick="uploadMenu();"><b>X</b></button>
    <p>Upload a file to the website, files over 100MB may have issues uploading due to Cloudflare restrictions.
        <br>
        Current location is <?php echo $dirDisplay;?>
    </p>
    <br>
    <input type="file" id="uploadFile" multiple>
    <button onclick="uploadFileProgressHandler();">Upload</button>
    <div id="status"></div>
    <div id="output1"></div>
</div>