<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Server {{ $server['name'] }} details</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/custom.css">
  </head>
  <body>
    <div class="container">
      <div id="vps-list">
        <h1>Server "{{ $server['name'] }}"</h1>
        <a href="/" class="btn btn-primary" role="button">Back to servers list</a>
        <button class="btn btn-primary" @click="showModalVps">Create new vps</button>
        <br><br>
        <table class="table" name="vps-list">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Ram</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for='vps in list'>
              <th scope="row">@{{ vps.id }}</th>
              <td>@{{ vps.name }}</td>
              <td>@{{ vps.ram }}</td>
              <td><a href="javascript:void(0)" @click="deleteVps(vps.id)"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div id="vps-modal">
      <div v-if="showModal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <slot name="header">
                  Create new VPS
                </slot>
              </div>
              <div class="modal-body">
                <slot name="body">
                  <input v-model="nameNewVps" placeHolder="Name"><br><br>
                  <input v-model="ramNewVps" placeHolder="Ram"><br>
                  <small>Available Ram: @{{ serverAvailableRam }} MB</small>
                </slot>
              </div>
              <div class="modal-footer">
                <slot name="footer">
                  <button class="btn btn-secondary" @click="showModal = false">
                    Close
                  </button>
                  <button class="btn btn-primary" @click="createVps">
                    Save
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
    var serverId = {{ $server['id'] }}
    var server_total_ram = {{ $server['ram'] }}
    var server_available_ram = {{ $server_available_ram }}
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script src="http://test-finale.tizianonicolai.com/js/vuex.js"></script>
    <script src="http://test-finale.tizianonicolai.com/js/serverDetail.js?ver=<?php echo rand(1,4713287481239); ?>"></script>
  </body>
</html>
