"use strict";

if (window.cordova && cordova.platformId !== "browser") {
  document.addEventListener("deviceready", function () {
    document.addEventListener("click", function (e) {
      var elem = e.target;

      while (elem != document) {
        if (elem.tagName === "A" && elem.hasAttribute("download")) {
          e.preventDefault();

          if (elem.getAttribute("href").slice(0, 5) === "data:") {
            var blob = dataURItoBlob(elem.getAttribute("href"));
            download(elem.getAttribute("download"), blob, blob.type);
          } else {
            fetch(elem.getAttribute("href"))
              .then(function (response) {
                return response.blob();
              })
              .then(function (blob) {
                return download(elem.getAttribute("download"), blob, blob.type);
              });
          }

          return;
        }

        elem = elem.parentNode;
      }
    });
  })
}

function download(filename, data, mimeType) {
  var blob = new Blob([data], {
    type: mimeType
  });
  if (window.cordova && cordova.platformId !== "browser") {
    document.addEventListener("deviceready", function() {
      var storageLocation = "";

      switch (device.platform) {
        case "Android":
          storageLocation = cordova.file.externalDataDirectory;
          break;

        case "iOS":
          storageLocation = cordova.file.documentsDirectory;
          break;
      }

      var folderPath = storageLocation;

      window.resolveLocalFileSystemURL(
        folderPath,
        function(dir) {
          dir.getFile(
            filename,
            {
              create: true
            },
            function(file) {
              file.createWriter(
                function(fileWriter) {
                  fileWriter.write(blob);

                  fileWriter.onwriteend = function() {
                    var url = file.toURL();
                    cordova.plugins.fileOpener2.open(url, mimeType, {
                      error: function error(err) {
                        console.error(err);
                        alert("Unable to download");
                      },
                      success: function success() {
                        console.log("success with opening the file");
                      }
                    });
                  };

                  fileWriter.onerror = function(err) {
                    alert("Unable to download");
                    console.error(err);
                  };
                },
                function(err) {
                  // failed
                  alert("Unable to download");
                  console.error(err);
                }
              );
            },
            function(err) {
              alert("Unable to download");
              console.error(err);
            }
          );
        },
        function(err) {
          alert("Unable to download");
          console.error(err);
        }
      );
    });
  } else {
    saveAs(blob, filename);
  }
}

function dataURItoBlob(dataURI) {
  var isBase64 = dataURI.split(",")[0].split(";")[1] === "base64";
  var byteString;

  if (isBase64) {
    // convert base64 to raw binary data held in a string
    // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    byteString = atob(dataURI.split(",")[1]);
  } else {
    byteString = dataURI.split(",")[1];
  } // separate out the mime component

  var mimeString = dataURI
    .split(",")[0]
    .split(":")[1]
    .split(";")[0]; // write the bytes of the string to an ArrayBuffer

  var ab = new ArrayBuffer(byteString.length); // create a view into the buffer

  var ia = new Uint8Array(ab); // set the bytes of the buffer to the correct values

  for (var i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i);
  } // write the ArrayBuffer to a blob, and you're done

  var blob = new Blob([ab], {
    type: mimeString
  });
  return blob;
});