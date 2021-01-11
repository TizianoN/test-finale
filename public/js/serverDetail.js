var vpsList = new Vue({
  el: "#vps-list",
  data: {
    list: [],
    available_ram: server_available_ram
  },
  methods: {
    loadList: async function ( success, error ) {
      await fetch('/api/vps/' + serverId + '/all')
        .then( response => response.json() )
        .then( function( data ) {
          vpsList.list = data;
      });

      await fetch('/api/server/' + serverId + '/ram/available')
        .then( response => response.json() )
        .then( function( data ) {
          vpsList.available_ram = data;
          vpsModal.available_ram = data;
      });
    },
    showModalVps: function () {
      vpsModal.showModal = true;
    },
    deleteVps: async function ( vpsId ) {
      await fetch('/api/vps/' + vpsId + '/delete')
        .then( response => response.json() )
        .then( function( data ) {
          vpsList.loadList();
      });
    }
  },
  mounted: function() {
    this.loadList()
  }
});

var vpsModal = new Vue({
  el: "#vps-modal",
  data: {
    showModal: false,
    nameNewVps: null,
    ramNewVps: null,
    available_ram: server_available_ram
  },
  methods: {
    createVps: function() {
      if(this.nameNewVps && this.ramNewVps) {
        fetch('/api/server/' + serverId + '/add/vps', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            'serverId': serverId,
            'vpsName': this.nameNewVps,
            'vpsRam': this.ramNewVps
          }),
        }).then( response => response.json() )
        .then( function( data ) {
          vpsList.loadList();
          vpsModal.showModal = false;
          vpsModal.nameNewVps = null;
          vpsModal.ramNewVps = null;
        });
      }
    }
  }
});
