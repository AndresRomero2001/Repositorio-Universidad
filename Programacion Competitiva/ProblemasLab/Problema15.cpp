// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <unordered_set>
#include <unordered_map>
#include <queue>
#include <cstring>
using namespace std;

//typedef struct {
//    int prim;
//    int seg;
//    int ter;
//    int cuar;
//};

const int MAX = 10000;
int ini, fin;
unordered_set<int> prohibidos;
bool visited[MAX];
int dist[MAX];
queue<int> q;

int next(int num, int i) {
    int prim, seg, ter, cuar;
    prim = num / 1000;
    seg = (num/100)%10;
    ter = (num/10)%10;
    cuar = num % 10;
    if (i == 0) if (prim != 9) (prim += 1) % 10; else prim = 0;
    else if (i == 1)   if (prim != 0) (prim -= 1) % 10; else prim = 9;
    else if (i == 2)   if (seg != 9) (seg += 1) % 10; else seg = 0;
    else if (i == 3)   if (seg != 0) (seg -= 1) % 10; else seg = 9;
    else if (i == 4)   if (ter != 9) (ter += 1) % 10; else ter = 0; 
    else if (i == 5)   if (ter != 0) (ter -= 1) % 10; else ter = 9;
    else if (i == 6)   if (cuar != 9) (cuar += 1) % 10; else cuar = 0; 
    else if (i == 7)   if (cuar != 0) (cuar -= 1) % 10; else cuar = 9;

    int aux = prim * 1000 + seg * 100 + ter * 10 + cuar;
    /*cout << prim << " " << seg << " " << ter << " " << cuar << endl;*/
    /*cout << aux << endl;*/
    return aux;
}

// función que resuelve el problema
int bfs(int ini, int dest) {

    visited[ini] = true;
    q.push(ini);
    while (!q.empty()) {
        int act = q.front();
        q.pop();
        
        for (int i = 0; i < 8; i++) {
            int sig = next(act, i);
            //cout << "sig: " << sig << " dest: " << dest << " act: " << act << endl;
            if (sig == dest) {
                //cout << "aaa sig: " << sig << " dest: " << dest << endl;
                //cout << "ZZZ " << dist[sig] << endl;
                return dist[act] + 1;
            }
            if (!visited[sig] && prohibidos.find(sig) == prohibidos.end()) {
                q.push(sig);
                dist[sig] = dist[act] + 1;
                visited[sig] = true;
            }
        }
    }
    return -1;
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    
    int nProhibidos;
    int prim, seg, ter, cuar;
    int aux;

    cin >> prim >> seg >> ter >> cuar;
    ini = prim * 1000 + seg * 100 + ter * 10 + cuar;
    cin >> prim >> seg >> ter >> cuar;
    fin = prim * 1000 + seg * 100 + ter * 10 + cuar;

    cin >> nProhibidos;

    for (int i = 0; i < nProhibidos; i++) {
        cin >> prim >> seg >> ter >> cuar;
        aux = prim * 1000 + seg * 100 + ter * 10 + cuar;
        prohibidos.insert(aux);
    }

    memset(visited, false, sizeof(visited));
    memset(dist, 0, sizeof(dist));

    /*cout << ini << " " << fin << endl;
    for (int a : prohibidos) {
        cout << a << " ";
    }
    cout << endl;*/

    /*cout << visited[ini] << endl;*/

    /*cout << "ini " << ini << endl;
    for (int a : prohibidos) {
        cout << a << " ";
    }
    cout << endl;*/
    
    /*cout << "a " << prohibidos.find(ini) << " " << prohibidos.end() << endl;*/
    if (ini == fin) cout << 0 << endl;
    else if (prohibidos.find(fin) != prohibidos.end()) cout << "-1" << endl;
    //else if (prohibidos.find(ini) != prohibidos.end()) cout << "-1" << endl;
    else {
        int aux2 = bfs(ini, fin);

        // escribir sol
        cout << aux2 << endl;
    }
    

    /*if (q.empty()) cout << "-1" << endl;
    if (aux2 > 0) cout << aux2 << endl;*/

    
    
    prohibidos.clear();
    q = queue<int>(); // para vaciar la cola
    
}

int main() {

    /*cout << next(20, 0);
    return 0;*/
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("datos4.txt");
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