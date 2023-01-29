// Nombre del alumno .....
// Andrés Romero y Alberto Pascual
// Usuario del Juez ......
// PC07


#include <iostream>
#include <iomanip>
#include <fstream>
#include <queue>
#include <vector>
#include <cstring>
using namespace std;

const int MAX = 10000;
queue<int> q;
bool visited[MAX];
int dist[MAX];

int next(int num, int boton) {
    if (boton == 0) return (num + 1)%10000;
    else if (boton == 1) return (num * 2)%10000;
    else return (num / 3)%10000;
}

// función que resuelve el problema
int bfs(int ini, int dest) {

    visited[ini] = true;
    q.push(ini);
    while (!q.empty()) {
        int act = q.front();
        q.pop();

        for (int i = 0; i < 3; i++) {
            int sig = next(act, i);

            if (sig == dest) return dist[act] + 1;

            if (!visited[sig]) {
                q.push(sig);
                dist[sig] = dist[act] + 1;
                visited[sig] = true;
            }
        }
    }
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int ini, fin;
    cin >> ini >> fin;
    
    if (! std::cin)
        return false;

    memset(visited, false, sizeof(visited));
    memset(dist, 0, sizeof(dist));

    int dist = bfs(ini, fin);
    
    // escribir sol
    if (ini == fin) cout << "0" << endl;
    else cout << dist << endl;
    

    q = queue<int>(); // para vaciar la cola

    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("datos.txt");
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