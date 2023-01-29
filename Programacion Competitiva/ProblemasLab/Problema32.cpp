// Nombre del alumno .....
// Usuario del Juez ......


#include <iostream>
#include <iomanip>
#include <fstream>
#include <queue>
#include <vector>
#include <cstring>
#include <algorithm>
using namespace std;

const int MAX_TIENDAS = 11; // tiendas + casa
const int MAX_NODES = 100000;
vector<vector<pair<int, int>>> adjList;
//vector<vector<pair<int, int>>> grafoReducido;
int tiendas[MAX_TIENDAS]; // tiendas y origen
int dist[MAX_NODES];
int distTiendas[MAX_TIENDAS][MAX_TIENDAS];

const int INF = 1000000;
int nI;
int nR;
int nT;


int V; // vértices del grafo completo, es nT+1 (num tiendas + casa)
vector<vector<int>> grafoReducido; // matriz de adyacencia del grafo
vector<vector<int>> memo; // tabla de DP (dynamic programming, donde se guardan los resultados de la recursion)
// devuelve el coste de ir desde pos al origen (el vértice 0)
// pasando por todos los vértices no visitados (con un bit a 0)

int tsp(int pos, int visitados) {
    if (visitados == (1 << V) - 1) // hemos visitado ya todos los vértices
        return grafoReducido[pos][0]; // volvemos al origen
    if (memo[pos][visitados] != -1)
        return memo[pos][visitados];
    int res = 1000000000; // INF
    for (int i = 1; i < V; ++i)
        if (!(visitados & (1 << i))) // no hemos visitado vértice i
            res = min(res, grafoReducido[pos][i] + tsp(i, visitados | (1 << i)));
    return memo[pos][visitados] = res;
}


void dijkstra(int s) {
    //dist.assign(adjList.size(), INF);
    dist[s] = 0;
    //priority_queue<pair<int, int>, vector<pair<int, int>>, greater<vector<pair<int,int>>>> pq;
    priority_queue<pair<int,int>, vector<pair<int, int>>, greater<pair<int,int>>> pq;
    pq.push({ 0, s });
    while (!pq.empty()) {
        pair<int,int> front = pq.top(); pq.pop();
        int d = front.first, u = front.second;
        if (d > dist[u]) continue;
        for (auto a : adjList[u]) {
            if (dist[u] + a.first < dist[a.second]) {
                dist[a.second] = dist[u] + a.first;
                pq.push({ dist[a.second], a.second });
            }
        }
    }
}

// función que resuelve el problema
//TipoSolucion resolver(TipoDatos datos) {
//    
//    
//}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    
    cin >> nI >> nR;

    adjList.assign(MAX_NODES, vector<pair<int, int>>());
    for (int i = 0; i < nR; i++) {
        int ini, fin, d;
        cin >> ini >> fin >> d;
        adjList[ini].push_back({ d,fin });
        adjList[fin].push_back({ d,ini });
    }

    // escribir sol
    
    cin >> nT;

    V = nT + 1; // tiendas + inicio

    memset(tiendas, -1, sizeof(tiendas));

    tiendas[0] = 0; // el nodo 0 es la casa
    for (int i = 1; i <= nT; i++) {
        int tienda;
        cin >> tienda;
        tiendas[i] = tienda;
    }

    memset(distTiendas, INF, sizeof(distTiendas));
    memset(dist, INF, sizeof(dist));
    //grafoReducido.assign(MAX_TIENDAS, vector<pair<int,int>>());
    grafoReducido.assign((nT+1)*(nT+1), vector<int>());

    for (int i = 0; i < V; i++) {
        
        if (tiendas[i] != -1) { // si la tienda i es un requisito. Empieza en 0 para q tmb se haga la dist desde la casa
            memset(dist, INF, sizeof(dist)); // reseteamos las dist entre dijkstra y dijkstra
            dijkstra(tiendas[i]);
            for (int j = 0; j < V; j++) {
                //grafoReducido[i].push_back({ dist[j], j }); // añadimos al grafo peque las distancias entre tiendas
                grafoReducido[i].push_back(dist[tiendas[j]]);
            }
        }
    }

    //cout << grafoReducido[0][0] << endl;
    
    memo.assign(V, vector<int>(1 << V, -1));
    int coste = tsp(0, 1);
    cout << coste << endl;

    //cout << grafoReducido[0][0] << endl;
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("verdejo.txt");
     auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
     #endif 
    
    
    int numCasos;
    std::cin >> numCasos;
    for (int i = 0; i < numCasos; ++i)
        resuelveCaso();

    
    // Para restablecer entrada. Comentar para acepta el reto
     #ifndef DOMJUDGE // para dejar todo como estaba al principio
     std::cin.rdbuf(cinbuf);
     system("PAUSE");
     #endif
    
    return 0;
}