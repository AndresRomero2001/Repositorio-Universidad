// Nombre del alumno .....
// Usuario del Juez ......


#include <iostream>
#include <iomanip>
#include <fstream>
using namespace std;

const int MAX_V = 10000;
int idx; // Siguiente entrada en euler y prof
int euler[2 * MAX_V - 1];
int prof[2 * MAX_V - 1]; // Prof. del nodo en euler[] (RMQ sobre ´el)
int first[MAX_V]; // Primera aparici´on del nodo i en euler[]

void eulerTour(int u, int parent, int d) { // d = depth
    first[u] = idx; euler[idx] = u; prof[idx] = d; ++idx;
    for (int i = 0; i < adj[u].size(); ++i) {
        int v = adj[u][i];
        if (v == parent) continue;
        eulerTour(v, u, d + 1);
        euler[idx] = u; prof[idx] = d; ++idx;
    }
}

// función que resuelve el problema
TipoSolucion resolver(TipoDatos datos) {
    
    
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    
    if (caso especial)
        return false;
    
    TipoSolucion sol = resolver(datos);
    
    // escribir sol
    
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
