(function () {
'use strict';
angular
.module('app')
.factory('sharedData', [
  sharedData,
]);

function sharedData() {
  var email;
  var folders;
  var allEmails = [
    {
      "from": "Titulo 1",
      "description": "Descripcion general del email que se va a mostrar en este campo, ocupando una porcion de la pantalla",
      "content": "contenido del mail 1 para mostrar en el area de email personal",
      "date": "Nov 1"
    },
    {
      "from": "Titulo 2",
      "description": "Descripcion general del email que se va a mostrar en este campo, ocupando una porcion de la pantalla",
      "content": "contenido del mail 2 para mostrar en el area de email personal",
      "date": "Nov 2"
    },
    {
      "from": "Titulo 3",
      "description": "Descripcion general del email que se va a mostrar en este campo, ocupando una porcion de la pantalla",
      "content": "contenido del mail 3 para mostrar en el area de email personal",
      "date": "Nov 3"
    },
    {
      "from": "Titulo 4",
      "description": "Descripcion general del email que se va a mostrar en este campo, ocupando una porcion de la pantalla",
      "content": "contenido del mail 4 para mostrar en el area de email personal",
      "date": "Nov 4"
    },

  ];
  return {
    getEmail: getEmail,
    setEmail: setEmail,
    getFolders: getFolders,
    setFolders: setFolders,
    getAllEmails: getAllEmails,
    setAllEmails: setAllEmails,
  };
  function getEmail() {
    return email;
  }
  function setEmail(newEmail) {
    email = newEmail;
  }
  function getFolders() {
    return folders;
  }
  function setFolders(newFoldersList) {
    folders = newFoldersList;
  }
  function getAllEmails() {
    return allEmails;
  }
  function setAllEmails(newEmailList) {
    allEmails = newEmailList;
  }
};
})();
