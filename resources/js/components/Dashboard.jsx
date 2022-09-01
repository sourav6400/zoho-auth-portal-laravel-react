// import queryString from 'query-string'
export default function Dashboard(){

    let search = window.location.search
    let param = search.split("=")[1]
    let code = param.split("&")[0]
    console.log(code)//123
    return(
        <div>{code}</div>
    )
}