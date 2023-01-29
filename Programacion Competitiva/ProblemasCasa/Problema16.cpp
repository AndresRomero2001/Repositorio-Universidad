// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07


#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
using namespace std;

vector<vector<char>> matriz;

const int MAXN = 2; // solo hay 0s y 1s
class Trie {
    int prefixes;
    int words;
    std::vector<Trie*> child;
public:
    Trie() :prefixes(0), words(0), child(MAXN, nullptr) {}
    ~Trie() {
        for (int i = 0; i < MAXN; ++i)
            delete child[i];
    }

    void add(const char* s) {
        if (*s == '\0') ++words;
        else {
            
            Trie* t;
            if (child[*s - '0'] == nullptr) {
                cout << "resta " << *s - '0' << endl;
                cout << "bbb" << endl;
                t = child[*s - '0'] = new Trie();
                t->prefixes = 1;
                cout << "ccc" << endl;
            }
            else {
                cout << "aaa" << endl;
                t = child[*s - '0'];
                t->prefixes++;
            }
            cout << "ddd" << endl;
            t->add(s + 1);
            cout << "eee" << endl;
        }
    }
};

// función que resuelve el problema
//TipoSolucion resolver(TipoDatos datos) {
//    
//    
//}

bool ok(int k, int i, int j, int filas, int cols) {
    int x1=0, x2=0, y1=0, y2=0; // coordenadas para ir viendo las palabras en las 8 dirs
  
    switch (k) {
    case 0: // arriba
        x1 = i - 1; x2 = i - 2; y1 = j; y2 = j;
        break;
    case 1: // arriba der
        x1 = i - 1; x2 = i - 2; y1 = j+1; y2 = j+2;
        break;
    case 2: // der
        x1 = i; x2 = i; y1 = j + 1; y2 = j + 2;
        break;
    case 3: // arriba izq
        x1 = i-1; x2 = i-2; y1 = j - 1; y2 = j - 2;
        break;
    case 4: // abajo der
        x1 = i+1; x2 = i+2; y1 = j + 1; y2 = j + 2;
        break;
    case 5: // abajo
        x1 = i+1; x2 = i+2; y1 = j; y2 = j;
        break;
    case 6: // abajo izq
        x1 = i+1; x2 = i+2; y1 = j -1; y2 = j - 2;
        break;
    case 7: // izq
        x1 = i; x2 = i; y1 = j - 1; y2 = j - 2;
        break;
    }
    
    if (x1 < 0 || x1 >= filas) return false;
    else if (y1 < 0 || y1 >= cols) return false;
    else if (x2 < 0 || x2 >= filas) return false;
    else if (y2 < 0 || y2 >= cols) return false;
    else return true;
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    
    int cols;
    cin >> cols;
    if (! std::cin)
        return false;
    
    int filas;
    cin >> filas;

    char nuevo;
    Trie arbol;
    matriz.assign(filas, vector<char>());

    int c = 0; 
    for (int i = 0; i < filas; i++) {
        for (int j = 0; j < cols; j++) {
            cin >> nuevo;
            
            matriz[i].push_back(nuevo);
            cout << "vuelta: " << c << endl;
            c++;
        }
    }
    
    int nPalabras;
    string palabra;

    cin >> nPalabras;
    for (int i = 0; i < nPalabras; i++) {
        cin >> palabra;
    }
    
    // calcular sol
   

    for (int i = 0; i < filas; i++) {
        for (int j = 0; j < cols; j++) {
            for (int k = 0; k < 8; k++) {
                if (ok(k, i, j, filas, cols)) {
                    string s = matriz[i][j] + matriz
                    arbol.add(&matriz[i][j]);
                }
            }
        }
    }
    
    
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-P16.1.in");
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