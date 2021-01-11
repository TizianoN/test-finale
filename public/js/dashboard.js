var serverList = new Vue({
  el: "#server-list",
  data: {
    list: [],
  },
  methods: {
    loadList: async function ( success, error ) {
      await fetch('http://test-finale.tizianonicolai.com/api/server/all')
        .then( response => response.json() )
        .then( function( data ) {
          serverList.list = data;
        });
    },
    showModalServer: function () {
      serverModal.showModal = true;
    },
    deleteServer: async function ( serverId ) {
      await fetch('http://test-finale.tizianonicolai.com/api/server/' + serverId + '/delete')
        .then( response => response.json() )
        .then( function( data ) {
          serverList.loadList();
      });
    }
  },
  mounted: function() {
    this.loadList()
  }
});

var serverModal = new Vue({
  el: "#server-modal",
  data: {
    showModal: false,
    nameNewServer: null,
    ramNewServer: null
  },
  methods: {
    createServer: function() {
      if(this.nameNewServer && this.ramNewServer) {
        fetch('http://test-finale.tizianonicolai.com/api/server/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            'serverName': this.nameNewServer,
            'serverRam': this.ramNewServer
          }),
        }).then( response => response.json() )
        .then( function( data ) {
          serverList.loadList();
          modal.showModal = false;
          serverModal.nameNewVps = null;
          serverModal.ramNewVps = null;
        });
      }
    }
  }
});
