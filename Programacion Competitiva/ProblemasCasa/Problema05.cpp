// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
//PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <queue>
using namespace std;

const int MAX = 100;
int df[] = { 1,1,0,-1,-1,-1,0,1 }, dc[] = { 0,1,1,1,0,-1,-1,-1 };
int mcf[] = { 2,1,-1,-2,-2,-1,1,2 }, mcc[] = { 1,2,2,1,-1,-2,-2,-1 }; // movimientos de caballo
char tablero[MAX][MAX];
bool visited[MAX][MAX];
int f, c, ax, ay;
bool haLlegado = false;
int dist;

bool ok(int i, int j) { // comprobar que una casilla esta dentro de la matriz
    return 0 <= i && i < f && 0 <= j && j < c;
}

bool muere(int i, int j) {
    for (int k = 0; k < 8; k++) {
        int nic = i + mcf[k], njc = j + mcc[k]; // posicion de un hipotetico caballo q puede atacar al rey
        if (ok(nic, njc) && tablero[nic][njc] == 'Z' && tablero[i][j] != 'B') // si en alguna de las posiciones en las q puede haber un caballo que coma al rey, hay un caballo, el rey muere
        {
            return true;
        }
    }
    return false;
}

// función que resuelve el problema
int dfs(int i, int j) {
    
    visited[i][j] = true;

    if (tablero[i][j] == 'B') {
        haLlegado = true;
        return 0;
    }


    for (int k = 0; k < 8; k++) {
        int ni = i + df[k], nj = j + dc[k];
        if (ok(ni, nj) && !visited[ni][nj] && tablero[ni][nj] != 'Z' && !muere(ni, nj)) {

            dist = min(dist+1, dfs(ni, nj)+1);
            return dist;
        }
    }
    return dist;
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    int n, m;
    cin >> n >> m;

    f = n; c = m;

    char aux;
    for (int i = 0; i < n; i++) {
        for (int j = 0; j < m; j++) {
            cin >> aux;
            if (aux == 'A') {
                ax = i;
                ay = j;
            }
            tablero[i][j] = aux;
        }
    }
    
    for (int i = 0; i < n; i++) {
        for (int j = 0; j < m; j++) {
            visited[i][j] = false;
        }
    }

    int dist = m * n;
    int min = m * n; // es imposible que un camino tenga mas de m*n casillas
    int sol = dfs(ax, ay);
    if (!haLlegado)
        cout << "King Peter, you can't go now!" << endl;
    else cout << "Minimal possible length of a trip is " << sol << endl;

    
    // escribir sol
    /*for (int i = 0; i < n; i++) {
        for (int j = 0; j < m; j++) {
            cout << tablero[i][j] << " ";
        }
        cout << endl;
    }*/
    haLlegado = false;
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("prueba3.txt");
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