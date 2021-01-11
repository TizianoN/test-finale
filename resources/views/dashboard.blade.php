<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/custom.css">
  </head>
  <body>
    <div class="container">
      <div id="server-list">
        <h1>My servers</h1>
        <button class="btn btn-primary" @click="showModalServer">Create new server</button>
        <br><br>
        <table class="table" name="server-list">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Ram</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for='server in list'>
              <th scope="row">@{{ server.id }}</th>
              <td>@{{ server.name }}</td>
              <td>@{{ server.ram }}</td>
              <td><a :href="'/server/' + server.id + '/edit'"><i class="fas fa-edit"></i></a></td>
              <td><a href="javascript:void(0)" @click="deleteServer(server.id)"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div id="server-modal">
      <div v-if="showModal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <slot name="header">
                  Create new Server
                </slot>
              </div>
              <div class="modal-body">
                <slot name="body">
                  <input v-model="nameNewServer" placeHolder="Name"><br><br>
                  <input v-model="ramNewServer" placeHolder="Ram"><br>
                </slot>
              </div>
              <div class="modal-footer">
                <slot name="footer">
                  <button class="btn btn-secondary" @click="showModal = false">
                    Close
                  </button>
                  <button class="btn btn-primary" @click="createServer">
                    Save
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="/js/vue.js"></script>
    <script src="/js/vuex.js"></script>
    <script src="/js/dashboard.js?ver=<?php echo rand(1,4713287481239); ?>"></script>
  </body>
</html>
