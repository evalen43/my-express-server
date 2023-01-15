// var http=require("http");
// var fs=require("fs");
// http.createServer(function(req,res){
//     fs.readFile('index.html',function(err,data){
//         res.writeHead(200,{'Content-Type': 'text/html'});
//         res.write(data);
        
//         res.end();
//     })
// }).listen(3000, function(){
//     console.log("Server started on port 3000")});

const express=require("express");
const app=express();
app.use(express.static("public"));
app.get("/",function(req,res){
    res.sendFile(__dirname + "/index.html");
});
app.listen(3000, function(){
    console.log("Server started on port 3000");
});
 