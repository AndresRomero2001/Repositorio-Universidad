// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07


#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <algorithm>
using namespace std;

int df[] = { 1,0,-1,0 }, dc[] = { 0,1,0,-1 };
const int MAX = 50;
char matriz[MAX][MAX];
bool visited[MAX][MAX];
int x, y;
int nProblema = 1;

class ord {
public:
    ord() {}
    bool operator() (const pair<char, int> a, const pair<char, int> b) const
    {
        if (b.second < a.second) return true;
        else if (b.second == a.second){
            if (b.first > a.first) return true;
        }
        return false;
    }
};

bool ok(int i, int j) {
    return 0 <= i && i < x && 0 <= j && j < y;
}

// función que resuelve el problema
int dfs(int i, int j, char letra) {
    int tam = 1; visited[i][j] = true;
    for (int k = 0; k < 4; ++k) {
        int ni = i + df[k], nj = j + dc[k];
        if (ok(ni, nj) && matriz[ni][nj] == letra && !visited[ni][nj])
            tam += dfs(ni, nj, letra);
    }
    return tam;
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    cin >> x >> y;
    if (x == 0 && y == 0)
        return false;

    for (int i = 0; i < x; i++) {
        for (int j = 0; j < y; j++) {
            char aux;
            cin >> aux;
            matriz[i][j] = aux;
        }
    }

    for (int i = 0; i < x; i++) {
        for (int j = 0; j < y; j++) {
            visited[i][j] = false;
        }
    }

    vector<pair<char, int>> v;
    int tam;
    for (int i = 0; i < x; ++i) {
        for (int j = 0; j < y; ++j) {
            if (!visited[i][j] && matriz[i][j] != '.') {
                tam = dfs(i, j, matriz[i][j]);
                //cout << "letra: " << matriz[i][j] << "tamano: " << tam << endl;
                v.push_back({ matriz[i][j], tam });
            }
        }
    }
    sort(v.begin(), v.end(), ord());
    // escribir sol
    cout << "Problem " << nProblema << ":" << endl;
    for (int i = 0; i < v.size(); i++) {
        cout << v[i].first << " " << v[i].second << endl;
    }
    nProblema++;
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-11.1.in");
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
