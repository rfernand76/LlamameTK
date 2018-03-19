mkdir log
nohup nodejs VQServer.js     >log/VQServer.log&
nohup nodejs VQHttpServer.js >log/VQHttpServer.log&
