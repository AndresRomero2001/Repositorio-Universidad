// Nombre del alumno .....
// Alberto Pascual y Andrés Romero
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <queue>
using namespace std;

const int MAX = 999;
int matriz[MAX][MAX];
int df[] = { 1,0,-1,0 }, dc[] = { 0,1,0,-1 };
int f, c;
queue<int> q;
int coste[MAX][MAX];


bool ok(int i, int j) {
    return 0 <= i && i < f && 0 <= j && j < c;
}

// función que resuelve el problema
void dijkstra(int ini) {
    
    q.push(ini);
    while (!q.empty()) {
        int posAct = q.front(); q.pop();
        if (matriz[posAct] > coste[posAct]) continue;
        if (posAct == 0) {

        }
        else if (posAct == 4) {
        }
        else if (posAct == 5 * (f - 1)) {// esquina abajo dcha
        }
        else if (posAct == 5 * (f - 1) + c - 1) { // esquina abajo dcha

        }
        for (int i = 0; i < 4; i++) {
            
        }
        for (auto a : adjList[u]) {
            if (dist[u] + a.first < dist[a.second]) {
                dist[a.second] = dist[u] + a.first;
                pq.push({ dist[a.second], a.second });
            }
        }
    }
}
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    
    cin >> f >> c;

    for (int i = 0; i < f; i++) {
        for (int j = 0; j < c; j++) {
            int aux;
            cin >> aux;
            matriz[i][j] = aux;
        }
    }

    //memset(coste, INT_MAX, sizeof(coste));
    for (int i = 0; i < f; i++) {
        for (int j = 0; j < c; j++) {
            coste[i][j] = INT_MAX;
        }
    }

    coste[0][0] = 0;
    
    /*TipoSolucion sol = resolver(datos);*/
    // escribir sol
    /*for (int i = 0; i < f; i++) {
        for (int j = 0; j < c; j++) {
            cout << matriz[i][j] << " ";
        }
        cout << endl;
    }
    cout << endl;*/
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-13.1.in");
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