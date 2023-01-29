// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <cstring>
#include <queue>
using namespace std;

// función que resuelve el problema
//TipoSolucion resolver(TipoDatos datos) {
//    
//    
//}

const int INF = 1000000;
const int MAX_NODES = 100;
int nN, s, t, nC;
vector<vector<int>> adj;
int caps[MAX_NODES][MAX_NODES];
queue<int> q;
bool visited[MAX_NODES];
int parent[MAX_NODES];

void bfs(int s, int t) {
    q.push(s);
    parent[s] = -1; visited[s] = true;
    while (!q.empty()) {
        int u = q.front(); q.pop();
        if (u == t) break;
        for (int i = 0; i < adj[u].size(); ++i) {
            int v = adj[u][i];
            if (!visited[v] && (caps[u][v] > 0)) {
                parent[v] = u;
                visited[v] = true;
                q.push(v);
            }
        }
    }
}

int sendFlow(int s, int t) {
    // Intentamos llegar de s a t
    bfs(s, t);
    if (!visited[t])
        return 0; // No pudimos
    // Buscamos capacidad m´as peque˜na en el camino
    int flow = INF, v = t;
    while (v != s) {
        flow = min(caps[parent[v]][v], flow);
        v = parent[v];
    }
    // Mandamos flujo
    v = t;
    while (v != s) {
        caps[parent[v]][v] -= flow;
        caps[v][parent[v]] += flow; // INVERSA
        v = parent[v];
    }
    return flow;
}

int edmondsKarp(int s, int t) {
    int ret = 0;
    int flow = 0;
    do {
        flow = sendFlow(s, t);
        cout << "flow: " << flow << endl;
        ret += flow;
    } while (flow > 0);
    return ret;
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    cin >> nN;
    if (nN == 0)
        return false;

    cin >> s >> t >> nC;

    adj.assign(nN+1, vector<int>());
    memset(caps, 0, sizeof(caps+1));
    memset(visited, false, sizeof(visited + 1));
    memset(parent, -1, sizeof(parent + 1));

    for (int i = 1; i <= nC; i++) {
        int ini,fin,c;
        cin >> ini >> fin >> c;
        adj[ini].push_back(fin);
        adj[fin].push_back(ini);
        caps[ini][fin] = c;
        caps[fin][ini] = c;
    }
    
    //TipoSolucion sol = resolver(datos);
    
    int res = edmondsKarp(s, t);
    cout << res << endl;
    
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-P11.1.in");
     auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
     #endif 
    
    
    while (resuelveCaso())
        ;

    
    // Para restablecer entrada. Comentar para acepta el reto
     #ifndef DOMJUDGE // para dejar todo como estaba al principio
     std::cin.rdbuf(cinbuf);
     system("PAUSE");
     #endif
    
    return 0;
}
