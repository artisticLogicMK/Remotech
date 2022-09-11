import { createStore } from 'vuex'

export default createStore({
  state: {
    //display state of job imformation display panel
    infoPanelOverlap: false,
    
    //store list of pre-given skills here
    skills: [
      'Angular',
      'ASP.NET',
      'AWS',
      'Backend',
      'C++',
      'Carbon',
      'CloudOps',
      'DevOps',
      'Django',
      'Express.js',
      'Frontend',
      'Flutter',
      'Go',
      'HTML/CSS',
      'Java',
      'Junior',
      'Javascript',
      'Kotlin',
      'Laravel',
      'Node.js',
      'PHP',
      'Python',
      'Ruby/Rails',
      'React',
      'Senior','Senior',
      'Vue'
    ],
    
    //toggle state of menu navbar
    menuToggle: false,

    jobEdited: false
  },
  
  mutations: {
    toggleMenu(state) {
      state.menuToggle = !state.menuToggle
    },

    toggleInfoPanel(state, bool) {
      state.infoPanelOverlap = bool
    },

    jobEdited(state, bool) {
      state.jobEdited = bool
    }
  },
  
  actions: {
    
  },
  
  getters: {},
  modules: {}
})
